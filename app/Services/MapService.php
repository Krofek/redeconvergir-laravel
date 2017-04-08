<?php
namespace App\Services;

class MapService
{
    static public function applyFilters($query, $filters)
    {
        if(isset($filters['categories'])){
            $query->whereIn('id', $filters['categories']);
        }
        if(isset($filters['audiences'])){
            $query->whereIn('id', $filters['audiences']);
        }
    }
}