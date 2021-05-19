<?php

namespace App\Http\Middleware\Others;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMode
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
        if (\getSetting('maintenance_mode') == 'Y') {
            if ($request->user()->hasRole('Developer')) {
                return $next($request);
            }
            abort(503);
        }
        return $next($request);
    }
}
