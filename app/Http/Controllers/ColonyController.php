<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyMaster;
use App\Models\PropertyLeaseDetail;

class ColonyController extends Controller
{
    public function localityBlocks(Request $request){
        $blocks = PropertyMaster::select('block_no')
                    ->where('new_colony_name', $request->locality)
                    ->orderByRaw("CAST(block_no AS UNSIGNED), block_no")
                    ->distinct()
                    ->get();
        return $blocks;
    }

    public function blockPlots(Request $request){
        // $plots = PropertyMaster::where('new_colony_name',$request->locality)->where('block_no',$request->block)->orderBy('plot_or_property_no')->distinct()->pluck('plot_or_property_no');
        $plots = PropertyMaster::select('plot_or_property_no')
                    ->where('new_colony_name', $request->locality)
                    ->where('block_no',$request->block)
                    ->orderByRaw("CAST(plot_or_property_no AS UNSIGNED), plot_or_property_no")
                    ->distinct()
                    ->get();
        return $plots;
        
    }

    public function plotKnownas(Request $request){
        $property = PropertyMaster::where('new_colony_name',$request->locality)->where('block_no',$request->block)->where('plot_or_property_no',$request->plot)->first();
        $property_master_id = $property['id'];
        $knownAs = PropertyLeaseDetail::where('property_master_id',$property_master_id)->pluck('presently_known_as');
        return $knownAs;
    }
}
