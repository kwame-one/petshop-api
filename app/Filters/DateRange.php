<?php

namespace App\Filters;

use Carbon\Carbon;

class DateRange
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        $dateRange = request('dateRange');

        if (!empty($dateRange) && is_array($dateRange)) {
            $from = isset($dateRange['from']) ? $dateRange['from'] : null;
            $to = isset($dateRange['to']) ? $dateRange['to'] : null;

            try {
                $dateFrom = Carbon::parse($from)->toDateString();
                $dateTo = Carbon::parse($to)->toDateString();
                $builder->whereRaw('DATE(orders.created_at) >= ? and DATE(orders.created_at) <= ? ', [$dateFrom, $dateTo]);
            } catch (\Exception $e) {
                logger('error parsing date');
                logger($e->getMessage());
            }
        }

        return $builder;
    }
}