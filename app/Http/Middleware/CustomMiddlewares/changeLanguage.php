<?php

namespace App\Http\Middleware\CustomMiddlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class changeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (isset($request->lang) && $request->lang == "ar") {
            App::setlocale('ar'); //alternative way is            app()->setLocale('ar');
            return $next($request);
        }
        if (isset($request->lang) && $request->lang == "en") {
            App::setlocale('en'); //alternative way is            app()->setLocale('ar');
            return $next($request);
        }
        return response()->json(['message' => 'langauge failure']);

    }
}
