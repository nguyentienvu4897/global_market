<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseConnectionManager
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
        // Chỉ kiểm tra database health cho API routes và admin routes
        if ($request->is('api/*') || $request->is('admin/*')) {
            try {
                // Sử dụng cache để tránh query liên tục
                $health = \App\Services\DatabaseConnectionService::getHealthStatus();

                // Nếu cache cũ hơn 60 giây, kiểm tra lại
                if (!$health['timestamp'] || $health['timestamp']->diffInSeconds(now()) > 60) {
                    $health = \App\Services\DatabaseConnectionService::checkConnectionHealth();
                }

                if ($health['status'] !== 'healthy') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Dịch vụ tạm thời không khả dụng. Vui lòng thử lại sau.',
                        'error' => 'Database connection failed'
                    ], 503);
                }
            } catch (\Exception $e) {
                // Chỉ log error nếu không phải "Too many connections"
                if (strpos($e->getMessage(), 'Too many connections') === false) {
                    Log::error('Database connection failed: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Dịch vụ tạm thời không khả dụng. Vui lòng thử lại sau.',
                    'error' => 'Database connection failed'
                ], 503);
            }
        }

        return $next($request);
    }
}
