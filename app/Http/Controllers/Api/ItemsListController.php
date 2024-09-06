<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LogisticItem;
use App\Models\LogisticRequestItem;
use Illuminate\Http\Request;

class ItemsListController extends Controller
{
    public function getItemsDetails()
    {
        $items = LogisticItem::with(['logisticCategory:id,name', 'availableStock', 'latestRequest'])
            ->select('id', 'name', 'label', 'category_id')
            ->where('status', 'active') 
            ->get();

        $items = $items->map(function ($item) {
            $availableUnits = $item->availableStock ? $item->availableStock->available_units : 0;

            $latestPendingRequest = LogisticRequestItem::where('logistic_items_id', $item->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($latestPendingRequest) {
                if ($availableUnits == $latestPendingRequest->available_units) {
                    $availableAfterRequest = $latestPendingRequest->available_after_request;
                } else {
                    $pendingRequestsTotalUnits = LogisticRequestItem::where('logistic_items_id', $item->id)
                        ->where('status', 'pending')
                        ->sum('requested_units');

                    $availableAfterRequest = $availableUnits - $pendingRequestsTotalUnits;
                }
            } else {
                $availableAfterRequest = $availableUnits;
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'label' => $item->label,
                'category_name' => $item->logisticCategory->name,
                'category_id' => $item->logisticCategory->id,
                'available_units' => $availableAfterRequest, 
            ];
        });

        return response()->json($items);
    }
}
