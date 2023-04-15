<?php

namespace App\Filters;

class PromotionValid
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        if (!empty(request('valid'))) {
            $valid = request()->boolean('valid');

            if ($valid) {
                $builder->whereDate('metadata->valid_from', '>=', now()->toDateString())
                    ->whereDate('metadata->valid_to', '<=', now()->toDateString());
            }
        }

        return $builder;
    }
}