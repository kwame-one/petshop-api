<?php

namespace App\Filters\Order;

abstract class BaseOrder
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        if (request()->has('sortBy') && !empty(request('sortBy'))) {
            $sortBy = in_array(request('sortBy'), $this->columns()) ? request('sortBy'): 'created_at';

            $direction = request()->boolean('desc', 'true') ? 'desc' : 'asc';

            $builder->orderBy($sortBy, $direction);
        }

        return $builder;
    }

    abstract public function columns(): array;
}