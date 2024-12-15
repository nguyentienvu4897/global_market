<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::guard('admin')->user() && Auth::guard('admin')->user()->can($permission) || Auth::guard('admin')->user()->id == 1) {
            return $next($request);
        } else {
			if ($request->ajax()){
                return errorResponse("Không có quyền!");
            }
            return response()->view('not_found');
        }
    }
}
