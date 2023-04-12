<?php

namespace App\Filters;

class NonAdminUser
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        return $builder->where('is_admin', 0);
    }

}