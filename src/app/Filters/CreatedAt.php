<?php

namespace App\Filters;

use Carbon\Carbon;

class CreatedAt
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        if (request()->has('created_at') && !empty(request('created_at'))) {
            $createdAt = strtolower(request('created_at'));

            try {
                $date = Carbon::parse($createdAt);
                $builder->whereDate('created_at', $date);
            } catch (\Exception $e) {
                logger('error parsing date');
            }
        }

        return $builder;
    }

}