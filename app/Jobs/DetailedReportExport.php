<?php

namespace App\Jobs;

use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Item;
use Mail;
use App\Mail\DownloadReady;
use Illuminate\Support\Facades\Storage;

class DetailedReportExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $filter;
    protected $email;
    public function __construct($filter, $email)
    {
        $this->filter = $filter;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filters = $this->filter;
        $reportService = new ReportService();
        $properties = $reportService->detailedReport($filters, true);
        $rows = [];
        foreach ($properties as $prop) {
            $propertyTypeNew  = (isset($propertyDetail->propertyLeaseDetail) && isset($propertyDetail->propertyLeaseDetail->property_type_at_present)) ? $propertyDetail->propertyLeaseDetail->property_type_at_present : null;
            $propertyTypeNewName = !is_null($propertyTypeNew) ? Item::itemNameById($propertyTypeNew) : '';
            $propertySubTypeNew  = (isset($propertyDetail->propertyLeaseDetail) && isset($propertyDetail->propertyLeaseDetail->property_sub_type_at_present)) ? $propertyDetail->propertyLeaseDetail->property_sub_type_at_present : null;
            $propertySubTypeNewName = !is_null($propertySubTypeNew) ? Item::itemNameById($propertySubTypeNew) : '';
            if ($prop->splitedPropertyDetail->count() > 0) {

                foreach ($prop->splitedPropertyDetail as $child) {

                    $rows[] = [
                        'Property Id' => $prop->unique_propert_id ?? '',
                        'Old Property Id' => $prop->old_propert_id ?? '',
                        'File Number' => $prop->unique_file_no ?? '',
                        'Old File Number' => $prop->file_no ?? '',
                        'Land Type' => $prop->landTypeName ?? '',
                        'Property Status' => $child->statusName ?? '',
                        'Property Type' => $prop->propertyTypeName ?? '',
                        'Property SubType' => $prop->propertySubtypeName ?? '',
                        'Is Land Use Changed' => isset($prop->propertyLeaseDetail->is_land_use_changed) ? 'Yes'  : 'No',
                        'Latest Property Type' => $propertyTypeNewName,
                        'Latest Property SubType' => $propertySubTypeNewName,
                        'Section' => $prop->section_code ?? '',
                        'Address' => $prop->block_no . '/' . $prop->plot_or_property_no . '/' . $prop->oldColony->name ?? '',
                        'Premium (₹)' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->premium . '.' . $prop->propertyLeaseDetail->premium_in_paisa ?? $prop->propertyLeaseDetail->premium_in_aana : '',
                        'Ground Rent (₹)' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->gr_in_re_rs . '.' . $prop->propertyLeaseDetail->gr_in_paisa ?? $prop->propertyLeaseDetail->gr_in_aana : '',
                        'Area' => $child->current_area ?? '',
                        'Area in Sqm' => $child->area_in_sqm ??  '',
                        'Colony' => $prop->oldColony->name ?? '',
                        'Block' => $prop->block_no ?? '',
                        'Plot' => $prop->plot_or_property_no ?? '',
                        'Presently Known As' => $child->presently_known_as ?? '',
                        'Lease Type' => $prop->propertyLeaseDetail->leaseTypeName ?? '',
                        'Date Of Allotment' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->doa : '',
                        'Date Of Execution' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->doe : '',
                        'Date Of Expiration' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->date_of_expiration : '',
                        'Start Date Of GR' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->start_date_of_gr : '',
                        'RGR Duration' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->rgr_duration : '',
                        'First RGR Due On' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->first_rgr_due_on : '',
                        'Last Inspection Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_inspection_ir_date : '',
                        'Last Demand Letter Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_letter_date : '',
                        'Last Demand Id' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_id : '',
                        'Last Demand Amount' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_amount : '',
                        'Last Amount Received' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_amount_received : '',
                        'Last Amount Received Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_amount_received_date : '',
                        'Total Dues' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->total_dues : '',
                        'Latest Lessee Name' => $prop->currentLesseeName ?? '',
                        'Lessee Address' => $prop->propertyContactDetail->address ?? '',
                        'Lessee Phone' => $prop->propertyContactDetail->phone_no ?? '',
                        'Lessee Email' => $prop->propertyContactDetail->email ?? '',
                        'Entry By' => $prop->user->name,
                        'Entry At' => $prop->created_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s')
                    ];
                }
            } else {
                $rows[] = [
                    'Property Id' => $prop->unique_propert_id ?? '',
                    'Old Property Id' => $prop->old_propert_id ?? '',
                    'File Number' => $prop->unique_file_no ?? '',
                    'Old File Number' => $prop->file_no ?? '',
                    'Land Type' => $prop->landTypeName ?? '',
                    'Property Status' => $prop->statusName ?? '',
                    'Property Type' => $prop->propertyTypeName ?? '',
                    'Property SubType' => $prop->propertySubtypeName ?? '',
                    'Is Land Use Changed' => isset($prop->propertyLeaseDetail->is_land_use_changed) ? 'Yes'  : 'No',
                    'Latest Property Type' => $propertyTypeNewName,
                    'Latest Property SubType' => $propertySubTypeNewName,
                    'Section' => $prop->section_code ?? '',
                    'Address' => $prop->block_no . '/' . $prop->plot_or_property_no . '/' . $prop->oldColony->name ?? '',
                    'Premium (₹)' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->premium . '.' . $prop->propertyLeaseDetail->premium_in_paisa ?? $prop->propertyLeaseDetail->premium_in_aana : '',
                    'Ground Rent (₹)' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->gr_in_re_rs . '.' . $prop->propertyLeaseDetail->gr_in_paisa ?? $prop->propertyLeaseDetail->gr_in_aana : '',
                    'Area' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->plot_area  : '',
                    'Area in Sqm' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->plot_area_in_sqm  : '',
                    'Colony' => $prop->oldColony->name ?? '',
                    'Block' => $prop->block_no ?? '',
                    'Plot' => $prop->plot_or_property_no ?? '',
                    'Presently Known As' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->presently_known_as : '',
                    'Lease Type' => $prop->propertyLeaseDetail->leaseTypeName ?? '',
                    'Date Of Allotment' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->doa : '',
                    'Date Of Execution' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->doe : '',
                    'Date Of Expiration' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->date_of_expiration : '',
                    'Start Date Of GR' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->start_date_of_gr : '',
                    'RGR Duration' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->rgr_duration : '',
                    'First RGR Due On' => isset($prop->propertyLeaseDetail) ? $prop->propertyLeaseDetail->first_rgr_due_on : '',
                    'Last Inspection Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_inspection_ir_date : '',
                    'Last Demand Letter Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_letter_date : '',
                    'Last Demand Id' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_id : '',
                    'Last Demand Amount' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_demand_amount : '',
                    'Last Amount Received' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_amount_received : '',
                    'Last Amount Received Date' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->last_amount_received_date : '',
                    'Total Dues' => isset($prop->propertyInspectionDemandDetail) ? $prop->propertyInspectionDemandDetail->total_dues : '',
                    'Latest Lessee Name' => $prop->currentLesseeName ?? '',
                    'Lessee Address' => $prop->propertyContactDetail->address ?? '',
                    'Lessee Phone' => $prop->propertyContactDetail->phone_no ?? '',
                    'Lessee Email' => $prop->propertyContactDetail->email ?? '',
                    'Entry By' => $prop->user->name,
                    'Entry At' => $prop->created_at->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s')
                ];
            }
        }
        if (!empty($rows)) {
            $fileName = 'public/exports/details' . date('YmdHis') . '.xlsx';
            (new FastExcel($rows))->export(Storage::path($fileName));
            if (!is_null($this->email)) {
                $link = '/download/' . base64_encode($fileName);
                Mail::to($this->email)->send(new DownloadReady($link));
            }
        }
    }
}
