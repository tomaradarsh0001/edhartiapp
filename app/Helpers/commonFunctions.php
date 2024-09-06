<?php

use App\Models\Item;
use Illuminate\Support\Facades\Log;

if (!function_exists('customNumFormat')) {
    function customNumFormat($num)
    {
        if ($num < 1000) {
            return $num;
        } else {
            $numStr = (string)$num;
            $decArray = explode('.', $numStr);
            $decimalPart = (count($decArray) > 1) ? $decArray[1] : '';
            $numParts = [];
            $devideBy = 1000;
            $intPart = (int)($num / $devideBy);
            $numParts[] = str_pad($num % $devideBy, 3, '0', STR_PAD_LEFT); //initially we need saperator before three digits from right, ones , thens, hundreds
            $devideBy = 100;
            while ($intPart > 99) {
                $tempInt = (int)($intPart / $devideBy);
                $numParts[] = str_pad($intPart % $devideBy, 2, '0', STR_PAD_LEFT); // add ',' after every two digits from rightafter 
                $intPart = $tempInt;
            }
            $intPart =  $intPart . ',' . implode(',', array_reverse($numParts));
            if (strlen($decimalPart) > 0) {
                return $intPart . '.' . $decimalPart;
            } else {
                return $intPart;
            }
        }
    }
}

if (!function_exists('dateDiffInYears')) {
    function dateDiffInYears($date1, $date2)
    {

        // Convert strings to DateTime objects
        $d1 = new \DateTime($date1);
        $d2 = new \DateTime($date2);

        // Calculate the difference between the two dates
        $interval = $d1->diff($d2);

        // Get the difference in years
        return $interval->y;
    }
}

if (!function_exists('getServiceType')) {
    function getServiceType($code)
    {
        $item = Item::where('item_code', $code)->first();
        if($item){
            return $item->id;
        } else {
            Log::info("Item not available for ". $code);
        }
    }
}

if (!function_exists('getStatusName')) {
    function getStatusName($code)
    {
        $item = Item::where('item_code', $code)->first();
        if($item){
            return $item->id;
        } else {
            Log::info("Item not available for ". $code);
        }
    }
}


if (!function_exists('getStatusDetailsById')) {
    function getStatusDetailsById($id)
    {
        $item = Item::find($id);
        if($item){
            return $item;
        } else {
            Log::info("Item not available for ". $id);
        }
    }
}

if (!function_exists('truncate_url')) {
    function truncate_url($url, $length = 20, $ellipsis = '....')
    {
        if (strlen($url) <= $length) {
            return $url;
        }

        return substr($url, 0, $length) . $ellipsis;
    }
}
