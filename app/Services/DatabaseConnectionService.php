<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DatabaseConnectionService
{
    /**
     * Kiểm tra và quản lý kết nối database
     */
    public static function checkConnectionHealth()
    {
        try {
            $startTime = microtime(true);

            // Test connection với timeout ngắn
            $pdo = DB::connection()->getPdo();

            // Kiểm tra connection có hoạt động không
            if (!$pdo) {
                throw new \Exception('No database connection available');
            }

            $endTime = microtime(true);
            $responseTime = round(($endTime - $startTime) * 1000, 2);

            // Lấy thông tin kết nối với timeout
            $connections = DB::select("SHOW STATUS LIKE 'Threads_connected'");
            $maxConnections = DB::select("SHOW VARIABLES LIKE 'max_connections'");

            $currentConnections = $connections[0]->Value ?? 0;
            $maxConn = $maxConnections[0]->Value ?? 0;
            $usagePercent = ($currentConnections / $maxConn) * 100;

            $healthData = [
                'status' => 'healthy',
                'current_connections' => $currentConnections,
                'max_connections' => $maxConn,
                'usage_percent' => round($usagePercent, 2),
                'response_time_ms' => $responseTime,
                'timestamp' => now()
            ];

            // Cache health data for 60 seconds
            Cache::put('db_health', $healthData, 60);

            // Log warning if usage is high
            if ($usagePercent > 80) {
                Log::warning("Database connection usage high: {$usagePercent}%");
            }

            return $healthData;
        } catch (\Exception $e) {
            $errorData = [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'timestamp' => now()
            ];

            Cache::put('db_health', $errorData, 60);

            // Không log "Too many connections" để tránh spam
            if (strpos($e->getMessage(), 'Too many connections') === false) {
                Log::error('Database health check failed: ' . $e->getMessage());
            }

            return $errorData;
        }
    }

    /**
     * Lấy thông tin health từ cache
     */
    public static function getHealthStatus()
    {
        return Cache::get('db_health', [
            'status' => 'unknown',
            'timestamp' => null
        ]);
    }

    /**
     * Đóng các kết nối không cần thiết
     */
    public static function cleanupIdleConnections()
    {
        try {
            // Lấy danh sách các kết nối idle
            $idleConnections = DB::select("
                SELECT Id, User, Host, Time, Command, State
                FROM INFORMATION_SCHEMA.PROCESSLIST
                WHERE Command = 'Sleep'
                AND Time > 300
                AND User != 'system user'
                AND Id != CONNECTION_ID()
            ");

            $killedCount = 0;
            foreach ($idleConnections as $connection) {
                try {
                    DB::statement("KILL {$connection->Id}");
                    $killedCount++;
                } catch (\Exception $e) {
                    Log::warning("Could not kill connection {$connection->Id}: " . $e->getMessage());
                }
            }

            if ($killedCount > 0) {
                Log::info("Cleaned up {$killedCount} idle database connections");
            }

            return $killedCount;
        } catch (\Exception $e) {
            Log::error('Failed to cleanup idle connections: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Tối ưu hóa database connection
     */
    public static function optimizeConnections()
    {
        try {
            // Đặt các biến session để tối ưu
            DB::statement("SET SESSION wait_timeout = 300");
            DB::statement("SET SESSION interactive_timeout = 300");
            DB::statement("SET SESSION net_read_timeout = 30");
            DB::statement("SET SESSION net_write_timeout = 30");

            // Log::info("Database connection optimized");
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to optimize connections: ' . $e->getMessage());
            return false;
        }
    }
}
