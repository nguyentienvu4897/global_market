<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$types)
    {
        if (Auth::guard('admin')->user() && (in_array(Auth::guard('admin')->user()->type, $types) || Auth::guard('admin')->user()->is_super_admin)) {
            return $next($request);
        } else {
            return response()->view('not_found');
        }
    }
}
