<?php

namespace App\Utils;

class AppUtil
{
    public static function paginate($query)
    {
        $limit = request('limit') ?? 10;
        $sortBy = request('sortBy') ?? 'created_at';
        $orderBy = request()->boolean('desc') ? 'desc' : 'asc';

        return $query->orderBy($sortBy, $orderBy)->paginate($limit);
    }

}