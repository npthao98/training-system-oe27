<?php

namespace App\Http\Middleware;

use Closure;

class CheckTrainee
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role_id == config('number.role.trainee')) {
            return $next($request);
        } else {
            abort(500);
        }
    }
}
