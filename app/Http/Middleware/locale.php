<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Locale
{
    public function handle($request, Closure $next)
    {
        $language = \Session::get('website_language', config('app.locale'));
        config(['app.locale' => $language]);

        return $next($request);
    }
}
