<?php

namespace App\Http\Middleware\CustomMiddlewares;

use App\Http\Traits\ApiGenralTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class checkAdminToken
{
    use ApiGenralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->returnError(401, 'Token is invalid');
            } else if ($e instanceof TokenExpiredException) {
                return $this->returnError(401, 'Token is expired');
            } else {
                return $this->returnError(401, 'Authorization token not found');
            }
        }
        if (!$user)
            return $this->returnError(331, 'unauthenticated');

        return $next($request);
    }
}
