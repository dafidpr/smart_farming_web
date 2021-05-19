<?php

namespace App\Http\Middleware\Others;

use Closure;
use Illuminate\Http\Request;

class UserCheckBlockStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\getInfoLogin()->block == 'Y') {
            abort(403);
        }
        return $next($request);
    }
}
