<?php

namespace App\Http\Middleware;

use Closure;

class VerifySyncUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken(); // "Authorization: Bearer {token}"
        $expected = config('sync_user.api_token');

        if ($token !== $expected) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
