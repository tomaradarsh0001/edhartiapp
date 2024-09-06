<?php
namespace App\Services;

class CommonService
{
    public function getUniqueID($model, $prefix, $column)
    {
        $maxId = $model::max($column);
    
        if ($maxId) {

            $nextId = $prefix . str_pad((int) substr($maxId, strlen($prefix)) + 1, 9 - strlen($prefix), '0', STR_PAD_LEFT);
        } else {
            $nextId = $prefix . '0000001';
        }
    
        return $nextId;
    }
    
}