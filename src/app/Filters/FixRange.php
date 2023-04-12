<?php

namespace App\Filters;

class FixRange
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        $range = request('fixRange');

        if (!empty($range)) {
            if ($range == 'today') {
                $builder->whereDate('created_at', '>=', now()->toDateString())
                    ->where('created_at', '<=', now()->toDateString());
            } elseif ($range == 'monthly') {
                $builder->whereDate('created_at', '>=', now()->startOfMonth()->toDateString())
                    ->where('created_at', '<=', now()->endOfMonth()->toDateString());
            } elseif ($range == 'yearly') {
                $builder->whereDate('created_at', '>=', now()->startOfYear()->toDateString())
                    ->where('created_at', '<=', now()->endOfYear()->toDateString());
            }
        }

        return $builder;
    }
}