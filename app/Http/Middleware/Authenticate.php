<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Auth;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    public function handle($request, Closure $next, ...$guards)
    {
        $guard = $guards[0] ?? null;

        if (!Auth::guard($guard)->check()) {
            // Redirect to appropriate login page based on guard
            switch ($guard) {
                case 'admin':
                    return redirect()->route('login');
                case 'client':
                    return redirect()->route('front.login-client');
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
