<?php

namespace App\Http\Middleware;

use App\Models\JwtToken;
use App\Utils\AppUtil;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Validator;

class ValidateTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = request()->bearerToken();
        if (!$token) {
            return response()->json(AppUtil::response(0, [], 'Unauthorized', []), \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
        }

        $token = JwtToken::query()->where('unique_id', request()->bearerToken())->first();

        if (!$token || now()->greaterThan($token->expires_at)) {
            return response()->json(AppUtil::response(0, [], 'Unauthorized', []), \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
        }
        $token->update(['last_used_at' => now()]);
        return $next($request);
    }
}
