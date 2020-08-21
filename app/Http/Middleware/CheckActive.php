<?php

namespace App\Http\Middleware;

use Closure;

class CheckActive
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->status == config('number.user.active')) {
            return $next($request);
        } else {
            auth()->logout();

            return redirect()->route('login')
                ->with('messenger', trans('both.message.account_inactive'));
        }
    }
}
