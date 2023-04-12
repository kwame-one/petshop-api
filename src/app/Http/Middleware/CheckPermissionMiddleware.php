<?php

namespace App\Http\Middleware;

use App\Models\JwtToken;
use App\Utils\AppUtil;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $token = request()->bearerToken();
        $jwt = JwtToken::query()
            ->where('unique_id', '=', $token)
            ->first();
        $permissions = collect($jwt->permissions ?? [])->pluck('name')->values()->toArray();
        if (!in_array($permission, $permissions)) {
            return response()->json(
                AppUtil::response(0, [], 'access denied',),
                \Illuminate\Http\Response::HTTP_FORBIDDEN
            );
        }
        return $next($request);
    }
}
