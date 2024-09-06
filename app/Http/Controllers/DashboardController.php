<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NewlyAddedProperty;
use App\Models\PropertyMaster;
use App\Models\SplitedPropertyDetail;
use App\Services\ColonyService;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Services\MisService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasAnyRole('super-admin', 'sub-admin')) {
            $data = self::getAdminData();
            return view('dashboard.admin', $data);
        } elseif ($user->hasAnyRole('section-officer', 'deputy-lndo')) {
            $data = self::getSectionData();
            return view('dashboard.section-user', $data);
        } else {
            return view('dashboard.user');
        }
    }


    public function propertyTypeDetails($typeId, $colonyId = null, $encodeJson = true, )
    {
        // dd($typeId, $encodeJson, $colonyId);
        $colonyQuery = !is_null($colonyId) ? " and old_colony_name = $colonyId" : '';
        $detailsQueryStatement = "select its.item_name as PropSubType, coalesce( t_data.counter, 0) as counter from(select property_type, property_sub_type, count(*) as counter  from (SELECT 
            *
        FROM
            property_masters
        WHERE
            property_type = $typeId
            $colonyQuery
            )p
        left join
        splited_property_details spd on p.id = spd.property_master_id
        group by property_type, property_sub_type)t_data
                right join (
                select items.item_name, pts.sub_type from
                (select * from property_type_sub_type_mapping where type = $typeId) pts
                join items on items.id = pts.sub_type
                )its
                on its.sub_type = t_data.property_sub_type";
        $propertyTypeDetailsResult = DB::select($detailsQueryStatement);
        if ($encodeJson) {
            return response()->json($propertyTypeDetailsResult);
        } else {
            return $propertyTypeDetailsResult;
        }
    }

    public function dashbordColonyFilter(Request $request, ColonyService $colonyService)
    {
        $colonyId = $request->colony_id;
        $colonyData = $colonyService->allPropertiesInColony($colonyId);
        $propertyTypeArray = ['residential' => 0, 'commercial' => 0, 'industrial' => 0, 'institutional' => 0, 'mixed' => 0, 'others' => 0];
        //sometime getting empty string instead of null, 0

        foreach ($colonyData as $item) {
            if ($item->property_type_name !== "") {
                $lowercaseTypeName = strtolower($item->property_type_name);
                if (array_key_exists($lowercaseTypeName, $propertyTypeArray)) {
                    $propertyTypeArray[$lowercaseTypeName]++;
                }
            }
            // Ensure numeric values for these properties
            $item->plot_value_ldo = is_numeric($item->plot_value_ldo) ? $item->plot_value_ldo : 0;
            $item->plot_value_cr = is_numeric($item->plot_value_cr) ? $item->plot_value_cr : 0;
            $item->plot_area = is_numeric($item->plot_area) ? $item->plot_area : 0;
        }
        $data['property_types'] = $propertyTypeArray;
        $areaRangeArray = [
            ['min' => null, 'max' => 50],
            ['min' => 50, 'max' => 100],
            ['min' => 100, 'max' => 250],
            ['min' => 250, 'max' => 350],
            ['min' => 350, 'max' => 500],
            ['min' => 500, 'max' => 750],
            ['min' => 750, 'max' => 1000],
            ['min' => 1000, 'max' => 2000],
            ['min' => 2000, 'max' => null]
        ];

        $areaRangeDataArray = [
            ['label' => '< 50', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '51-100', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '101-250', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '251-350', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '351-500', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '501-750', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '751-1000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '1001-2000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '> 2000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
        ];

        //total
        $data['total_count'] = $colonyData->count();
        $data['total_area'] = $colonyData->sum('plot_area');
        $data['total_area_formatted'] = customNumFormat(round($data['total_area']));
        $data['total_land_value_ldo'] = $colonyData->sum('plot_value_ldo');
        $data['total_land_value_ldo_formatted'] = '₹' . (($data['total_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['total_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['total_land_value_ldo'])));
        $data['total_land_value_circle'] = $colonyData->sum('plot_value_cr');
        // $data['total_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['total_land_value_circle'] / 10000000)) . ' Cr.';
        $data['total_land_value_circle_formatted'] = '₹' . (($data['total_land_value_circle'] > 10000000) ? (customNumFormat(round($data['total_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['total_land_value_circle'])));
        // Lease hold
        $leaseHold = $colonyData->where('property_status', 951);
        $data['lease_hold_count'] = $leaseHold->count();
        $data['lease_hold_area'] = customNumFormat(round($leaseHold->sum('plot_area')));
        $data['lease_hold_land_value_ldo'] = $leaseHold->sum('plot_value_ldo');
        // $data['lease_hold_land_value_ldo_formatted'] = '₹' . customNumFormat(round($data['lease_hold_land_value_ldo'] / 10000000)) . ' Cr.';
        $data['lease_hold_land_value_ldo_formatted'] = '₹' . (($data['lease_hold_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['lease_hold_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['lease_hold_land_value_ldo'])));
        $data['lease_hold_land_value_circle'] = $leaseHold->sum('plot_value_cr');
        // $data['lease_hold_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['lease_hold_land_value_circle'] / 10000000)) . ' Cr.';
        $data['lease_hold_land_value_circle_formatted'] = '₹' . (($data['lease_hold_land_value_circle'] > 10000000) ? (customNumFormat(round($data['lease_hold_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['lease_hold_land_value_circle'])));

        // Free hold
        $freeHold = $colonyData->where('property_status', 952);
        $data['free_hold_count'] = $freeHold->count();
        $data['free_hold_area'] = customNumFormat(round($freeHold->sum('plot_area')));
        $data['free_hold_land_value_ldo'] = $freeHold->sum('plot_value_ldo');
        // $data['free_hold_land_value_ldo_formatted'] = '₹' . customNumFormat(round($data['free_hold_land_value_ldo'] / 10000000)) . ' Cr.';
        $data['free_hold_land_value_ldo_formatted'] = '₹' . (($data['free_hold_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['free_hold_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['free_hold_land_value_ldo'])));
        $data['free_hold_land_value_circle'] = $freeHold->sum('plot_value_cr');
        // $data['free_hold_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['free_hold_land_value_circle'] / 10000000)) . ' Cr.';
        $data['free_hold_land_value_circle_formatted'] = '₹' . (($data['free_hold_land_value_circle'] > 10000000) ? (customNumFormat(round($data['free_hold_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['free_hold_land_value_circle'])));


        foreach ($areaRangeArray as $index => $range) {
            // Clone the original dataset to apply filters
            $filteredData = clone $colonyData;

            if (!is_null($range['min'])) {
                $filteredData = $filteredData->where('plot_area', '>', $range['min']);
            }
            if (!is_null($range['max'])) {
                $filteredData = $filteredData->where('plot_area', '<=', $range['max']);
            }

            // Calculate the sum for the filtered dataset
            $sum = $filteredData->sum('plot_area');

            // Store the result
            $areaRangeDataArray[$index]['count'] = $filteredData->count();
            $areaRangeDataArray[$index]['area'] = $sum;
            $areaRangeDataArray[$index]['percent_count'] = round((($filteredData->count() / $data['total_count']) * 100), 2);
            $areaRangeDataArray[$index]['percent_area'] = round((($sum / $colonyData->sum('plot_area')) * 100), 2);
        }
        $data['areaRangeData'] = $areaRangeDataArray;
        return response()->json($data);
    }

    private function getAdminData() //ColonyService $colonyService
    {
        $countAndTotalArea = DB::select('call property_count_and_area()');
        $data['totalCount'] = $countAndTotalArea[0]->total_count;
        $data['totalArea'] = $countAndTotalArea[0]->total_area;
        $data['totalLdoValue'] = $countAndTotalArea[0]->total_ldo_value;
        $data['totalCircleValue'] = $countAndTotalArea[0]->total_cr_value;
        $propArea = DB::select('call get_property_area_details()');

        //Added by Amita -- 27-06-2024
        /* $lh_land_val = DB::select("select  sum(l.plot_value_cr) as totalCrVal from property_masters p join property_lease_details l on 
                        p.id  = l.property_master_id where p.status = 951");
                        
        $fh_land_val = DB::select("select  sum(l.plot_value_cr) as totalCrVal from property_masters p join property_lease_details l on 
                        p.id  = l.property_master_id where p.status = 952"); */
        //End

        /** changes done by Nitin on 28.06.2024 */









        /** we need to transform the data to show it on table in dashboard */
        $labels = [];
        $counts = [];
        $areas = [];
        $firstRow = true;
        foreach ($propArea as $index => $col) {
            $rowKey = '';
            foreach ($col as $key => $val) {

                if ($key != 'type') {
                    if ($firstRow) {
                        array_push($labels, $key);
                    }
                    if (isset($rowKey) && $rowKey == 'count') {
                        array_push($counts, $val);
                    }
                    if (isset($rowKey) && $rowKey == 'area') {
                        array_push($areas, $val);
                    }
                } else {
                    $rowKey = $val;
                }
            }
            $firstRow = false;
        }
        $data['propertyAreaDetails'] = ['labels' => $labels, 'counts' => $counts, 'areas' => $areas];
        $statusCount = ['free_hold' => 0, 'lease_hold' => 0];
        $statusArea = ['free_hold' => 0, 'lease_hold' => 0];
        $statusLdoValue = ['free_hold' => 0, 'lease_hold' => 0];
        $statusCircleValue = ['free_hold' => 0, 'lease_hold' => 0];
        $statusCountData = DB::select('call count_status()');
        if (count($statusCountData) > 0) {
            foreach ($statusCountData as $row) {
                if ($row->item_name == 'Free Hold') {
                    $statusCount['free_hold'] = $row->counter;
                    $statusArea['free_hold'] = $row->total_area;
                    $statusLdoValue['free_hold'] = $row->ldo_value;
                    $statusCircleValue['free_hold'] = $row->cr_value;
                }
                if ($row->item_name == 'Lease Hold') {
                    $statusCount['lease_hold'] = $row->counter;
                    $statusArea['lease_hold'] = $row->total_area;
                    $statusLdoValue['lease_hold'] = $row->ldo_value;
                    $statusCircleValue['lease_hold'] = $row->cr_value;
                }
            }
        }
        $data['statusCount'] = $statusCount;
        $data['statusArea'] = $statusArea;
        $data['statusLdoValue'] = $statusLdoValue;
        $data['statusCircleValue'] = $statusCircleValue;
        /*
        $data['lh_land_val'] = $lh_land_val[0]->totalCrVal;   //Added by Amita -- 27-06-2024
        $data['fh_land_val'] = $fh_land_val[0]->totalCrVal;   //Added by Amita -- 27-06-2024 */


        // $property
        $propertyTypeCount = ['Residential' => 0, 'Commmercial' => 0, 'Industrial' => 0, 'Institutional' => 0, 'Mixed' => 0, 'Others' => 0];
        $propertyTypeArea = ['Residential' => 0, 'Commmercial' => 0, 'Industrial' => 0, 'Institutional' => 0, 'Mixed' => 0, 'Others' => 0];
        $propertyTypeCountData = DB::select('call count_property_type()');
        if (count($propertyTypeCountData) > 0) {
            foreach ($propertyTypeCountData as $row) {
                if ($row->item_name == 'Residential') {
                    $propertyTypeCount['Residential'] = $row->counter;
                    $propertyTypeArea['Residential'] = $row->total_area;
                }
                if ($row->item_name == 'Commercial') {
                    $propertyTypeCount['Commercial'] = $row->counter;
                    $propertyTypeArea['Commercial'] = $row->total_area;
                }

                if ($row->item_name == 'Industrial') {
                    $propertyTypeCount['Industrial'] = $row->counter;
                    $propertyTypeArea['Industrial'] = $row->total_area;
                }
                if ($row->item_name == 'Institutional') {
                    $propertyTypeCount['Institutional'] = $row->counter;
                    $propertyTypeArea['Institutional'] = $row->total_area;
                }
            }
        }
        $data['propertyTypeCount'] = $propertyTypeCount;
        $data['propertyTypeArea'] = $propertyTypeArea;
        $landTypeCount = ['Rehabilitation' => 0, 'Nazul' => 0];
        $landTypeCountData = DB::select('call count_land()');
        if (count($landTypeCountData) > 0) {
            foreach ($landTypeCountData as $row) {
                if ($row->item_name == 'Rehabilitation') {
                    $landTypeCount['Rehabilitation'] = $row->counter;
                }
                if ($row->item_name == 'Nazul') {
                    $landTypeCount['Nazul'] = $row->counter;
                }
            }
        }
        $data['landTypeCount'] = $landTypeCount;

        $barChartData = DB::select('call bar_chart_data()');
        $data['barChartData'] = $barChartData;
        $queryStatement = "SELECT 
        items.item_name AS property_type_name,
        items.id,
        COALESCE(pm.counter, 0) AS counter
        FROM
            (SELECT 
                *
            FROM
                items
            WHERE
                group_id = 1052 AND is_active = 1
            ORDER BY item_order) items
                LEFT JOIN
            (SELECT 
                t.property_type, COUNT(t.property_type) AS counter
            FROM
                (SELECT 
                property_type
            FROM
                property_masters
            WHERE
                is_joint_property IS NULL UNION ALL SELECT 
                m.property_type
            FROM
                splited_property_details spd
            JOIN property_masters m ON spd.property_master_id = m.id) t
            GROUP BY property_type) pm ON items.id = pm.property_type
        ORDER BY items.item_order";
        $queryResult = DB::select($queryStatement);
        $data['tabHeader'] = $queryResult;
        $tab1Data = $queryResult[0];
        $tab1Id = $tab1Data->id;
        $data['tab1Details'] = self::propertyTypeDetails($tab1Id, null, false);
        // dd($data['tab1Details']);

        //grt data for land value chart added on 03.07.2024 by Nitin
        $landValueData = DB::select('call land_value()')[0];
        $formattedLandValueData = ['labels' => [], 'values' => []];
        foreach ($landValueData as $i => $val) {
            $formattedLandValueData['labels'][] = "'" . $i . "'";
            $formattedLandValueData['values'][] = $val;
        }
        $data['landValueData'] = $formattedLandValueData;
        $colonyService = new ColonyService();
        $data['colonies'] = $colonyService->misDoneForColonies();
        return $data;
    }

    private function getSectionData()
    {
        //Added by Lalit -- 29-07-2024  Call the stored procedure and fetch results from user_registration table to show total registration, pending , approved, rejected etc..
        $countData = DB::select('CALL GetRegistrationCounts()');
        //Get count of Newly Added Property
        $newPropertyCount = NewlyAddedProperty::where('status',1376)->count();

        $data['registrations'] = ['total Registrations' => $countData[0]->total_count, 'Properties for Approval' => $newPropertyCount, 'approved' => $countData[0]->approved_count, 'rejected' => $countData[0]->rejected_count, 'transferred' => 10];
        
        $data['applications'] = ['total' => 60, 'pending' => 14, 'in_process' => 13, 'objected' => 12, 'rejected' => 11, 'disposed' => 10];
        $data['application_types']['application_of_substitution'] = ['in_process' => 12, 'disposed' => 11];
        $data['application_types']['application_of_mutation'] = ['in_process' => 12, 'disposed' => 11];
        $data['application_types']['application_of_conversion'] = ['in_process' => 12, 'disposed' => 11];
        $data['application_types']['application_of_NOC'] = ['in_process' => 12, 'disposed' => 11];
        $data['pendingCount'] = $newPropertyCount;
        return $data;
    }
}
