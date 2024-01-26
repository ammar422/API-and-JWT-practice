<?php

namespace App\Http\Middleware\CustomMiddlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ApiPassword')) {
            if ($request->ApiPassword != env('API_PASSWORD','IKaDwRTBRXU2tSqKLV9NjwShCEuq5s')) {
                return response()->json(['message' => 'authentication failure']);
            }
            return $next($request);
        }
        // return $next($request);
        return response()->json(['message' => 'you request dosen\'t have authentication api password']);
    }
}
