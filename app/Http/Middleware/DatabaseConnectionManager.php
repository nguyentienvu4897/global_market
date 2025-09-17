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
        try {
            // Kiểm tra kết nối database trước khi xử lý request
            DB::connection()->getPdo();

            // Log số lượng connection hiện tại (chỉ trong development)
            if (config('app.debug')) {
                $connections = DB::select("SHOW STATUS LIKE 'Threads_connected'");
                $connected = $connections[0]->Value ?? 0;
                Log::info("Database connections: {$connected}");
            }
        } catch (\Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());

            // Trả về lỗi 503 Service Unavailable
            return response()->json([
                'success' => false,
                'message' => 'Dịch vụ tạm thời không khả dụng. Vui lòng thử lại sau.',
                'error' => 'Database connection failed'
            ], 503);
        }

        return $next($request);
    }
}
