<?php

namespace App\Http\Middleware\CustomMiddlewares;

use App\Http\Traits\ApiGenralTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AssignGuard  
{
    use ApiGenralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if ($guard != null) {
            Auth()->shouldUse($guard);
            $token = $request->header('auth-token');
            $request->headers->set('auth-token', $token, true);
            $request->headers->set('Authorization', 'bearer ' . $token, true);
// return response()->json(collect($request->header()));
            try {
                $user = JWTAuth::parseToken()->authenticate();
                // $user=Auth::guard($guard)->user();
                // return response() ->json($user);
            } 
            catch (TokenExpiredException $ex) {
                return $this->returnError(301, $ex->getMessage());
            } 
            catch (JWTException $ex) {
                return $this->returnError(301, $ex->getMessage());
            }
        }

        return $next($request);
    }
}
