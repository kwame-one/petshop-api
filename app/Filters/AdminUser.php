<?php

namespace App\Filters;

class AdminUser
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        return $builder->where('is_admin', 1);
    }

}