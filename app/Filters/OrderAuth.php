<?php

namespace App\Filters;

use App\Models\User;
use App\Utils\AppUtil;

class OrderAuth
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        $uuid = AppUtil::getUserUuidFromToken(request()->bearerToken());
        $user = User::query()->where('uuid', '=', $uuid)->first();

        return $builder->where('user_id', $user ? $user->id : 0);
    }
}