<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
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
        $apiKey = $request->header('X-Api-Key');

        if (!$apiKey || $apiKey !== config('sync_user.api_token')) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid API Key'
            ], 401);
        }

        return $next($request);
    }
}
