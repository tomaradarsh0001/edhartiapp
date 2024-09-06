<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use App\Models\LogisticAvailableStock;
use App\Models\LogisticRequestItem;
use Illuminate\Http\Request;
use App\Services\CommonService;
use Illuminate\Support\Facades\Auth;
use App\Models\LogisticsStockHistory;

class RequestProcessingController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*public function index()
    {
        $logisticRequests = LogisticRequestItem::with('logisticItem')->get()->groupBy('request_id');

        return view('logistics.requestItem.index', compact('logisticRequests'));
    }*/

    public function index()
    {
        return view('logistics.requestItem.indexDatatable');
    }

    public function getLogisticRequestItems(Request $request)
    {
        // Start query with the correct relationship
        $query = LogisticRequestItem::query()->with('logisticItem');

        // List only actual database columns here, with special handling for related columns
        $columns = ['request_id', 'logisticItem.name', 'issued_units', 'status', 'created_at'];

        // Apply searching
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('request_id', 'LIKE', "%{$search}%")
                    ->orWhereHas('logisticItem', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('issued_units', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhereDate('created_at', 'LIKE', "%{$search}%");
            });
        }

        // Get total data and filtered data counts
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Apply ordering
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? null;
        $dir = $request->input('order.0.dir', 'asc');

        if ($order) {
            // Special case for ordering by related model column
            if ($order === 'logisticItem.name') {
                $query->leftJoin('logistic_items', 'logistic_request_items.logistic_item_id', '=', 'logistic_items.id')
                    ->orderBy('logistic_items.name', $dir);
            } else {
                $query->orderBy($order, $dir);
            }
        }

        // Apply pagination
        $limit = $request->input('length');
        $start = $request->input('start');
        $issueItemData = $query->offset($start)->limit($limit)->get();

        $data = [];
        foreach ($issueItemData as $row) {
            $nestedData = [];
            // Prepare data for the columns
            $nestedData['request_id'] = $row->request_id;

            // Get the details of logistic items
            $itemDetails = $row->logisticItem
                ? $row->logisticItem->name . ' (' . $row->requested_units . ')'
                : '';
            $nestedData['request_item_list'] = $itemDetails;
            $nestedData['issued_units'] = $row->issued_units ?? '';

            // Status column with conditional badge rendering
            $status = $row->status;
            if ($status == 'Approved') {
                $nestedData['status'] = '<span class="badge bg-success">' . $status . '</span>';
            } elseif ($status == 'Rejected') {
                $nestedData['status'] = '<span class="badge bg-danger">' . $status . '</span>';
            } else {
                $nestedData['status'] = '<span class="badge bg-secondary text-light">' . $status . '</span>';
            }

            $nestedData['request_date'] = $row->created_at ? $row->created_at->format('d/m/Y') : 'N/A';

            if (!in_array($status, ['Approved', 'Rejected'])) {
                $nestedData['action'] = '<a href="' . route('request.create', ['requestId' => $row->request_id]) . '">
                                <button class="btn btn-primary">Take Action</button>
                             </a>';
            } else {
                $nestedData['action'] = ''; // No action button for Approved or Rejected statuses
            }

            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }



    public function create($requestId)
    {
        $requestItems = LogisticRequestItem::where('request_id', $requestId)
            ->with(['logisticItem', 'Category']) // Eager load the category relationship
            ->get();

        if ($requestItems->isEmpty()) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        $requestItems->each(function ($item) {
            $availableStock = LogisticAvailableStock::where('logistic_items_id', $item->logistic_items_id)->first();
            $item->available_units = $availableStock ? $availableStock->available_units : 0;
        });

        return view('logistics.requestItem.create', compact('requestItems'));
    }



    public function updateStatus(Request $request, $requestId)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.logistic_items_id' => 'required|exists:logistic_items,id',
            'items.*.issued_units' => 'nullable|integer|min:0',
            'items.*.category_id' => 'required|exists:logistic_categories,id',
            'items.*.requested_units' => 'required|integer|min:1',
            'status' => 'required|in:approved,rejected',
        ]);

        foreach ($validated['items'] as $item) {
            $logisticRequestItem = LogisticRequestItem::where('request_id', $requestId)
                ->where('logistic_items_id', $item['logistic_items_id'])
                ->first();

            if ($logisticRequestItem) {
                if ($validated['status'] === 'rejected') {
                    $logisticRequestItem->issued_units = 0;

                    $latestRequest = LogisticRequestItem::where('logistic_items_id', $item['logistic_items_id'])
                        ->where('status', 'pending')
                        ->latest()
                        ->first();

                    if ($latestRequest) {
                        $latestRequest->available_after_request += $item['requested_units'];
                        $latestRequest->save();
                    }
                } else {
                    $logisticRequestItem->issued_units = $item['issued_units'];
                }

                $logisticRequestItem->status = $validated['status'];
                $logisticRequestItem->save();

                if ($validated['status'] === 'approved') {
                    $availableStock = LogisticAvailableStock::where('logistic_items_id', $item['logistic_items_id'])->first();
                    if ($availableStock) {
                        if ($availableStock->available_units < $item['issued_units']) {
                            return redirect()->back()->withErrors(['msg' => 'Available units are less than the issued units for item ID ' . $item['logistic_items_id']]);
                        }
                        $lastUnits = $availableStock->available_units;
                        $newAvailableUnits = $availableStock->available_units - $item['issued_units'];
                        $newUsedUnits = $availableStock->used_units + $item['issued_units'];

                        $lastIssuedEntry = LogisticsStockHistory::where('logistic_items_id', $item['logistic_items_id'])
                            ->whereNotNull('issued_units')
                            ->latest()
                            ->first();

                        $lastReducedUnits = $lastIssuedEntry ? $lastIssuedEntry->issued_units : 0;
                        $lastReducedDate = $lastIssuedEntry ? $lastIssuedEntry->issued_at : null;

                        $availableStock->available_units = $newAvailableUnits;
                        $availableStock->used_units = $newUsedUnits;
                        $availableStock->save();

                        LogisticsStockHistory::create([
                            'logistic_items_id' => $item['logistic_items_id'],
                            'category_id' => $item['category_id'],
                            'request_id' => $logisticRequestItem->id,
                            'request_unique_id' => $logisticRequestItem->request_id,
                            'available_units' => $newAvailableUnits,
                            'last_units' => $lastUnits,
                            'last_reduced_units' => $lastReducedUnits,
                            'last_reduced_date' => $lastReducedDate,
                            'issued_units' => $item['issued_units'],
                            'issued_to_user_id' => $logisticRequestItem->created_by,
                            'issued_by' => Auth::id(),
                            'issued_at' => now(),
                            'action' => 'issued',
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('requested_item.index')->with('success', 'Request updated successfully.');
    }
}
