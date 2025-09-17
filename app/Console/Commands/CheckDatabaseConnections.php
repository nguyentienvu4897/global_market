<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check-connections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra số lượng kết nối database hiện tại';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Lấy thông tin kết nối MySQL
            $connections = DB::select("SHOW STATUS LIKE 'Threads_connected'");
            $maxConnections = DB::select("SHOW VARIABLES LIKE 'max_connections'");
            $waitTimeout = DB::select("SHOW VARIABLES LIKE 'wait_timeout'");
            $interactiveTimeout = DB::select("SHOW VARIABLES LIKE 'interactive_timeout'");

            $currentConnections = $connections[0]->Value ?? 0;
            $maxConn = $maxConnections[0]->Value ?? 0;
            $waitTime = $waitTimeout[0]->Value ?? 0;
            $interactiveTime = $interactiveTimeout[0]->Value ?? 0;

            $this->info("=== THÔNG TIN KẾT NỐI DATABASE ===");
            $this->info("Kết nối hiện tại: {$currentConnections}");
            $this->info("Kết nối tối đa: {$maxConn}");
            $this->info("Wait timeout: {$waitTime} giây");
            $this->info("Interactive timeout: {$interactiveTime} giây");

            // Cảnh báo nếu gần đạt giới hạn
            $usagePercent = ($currentConnections / $maxConn) * 100;
            if ($usagePercent > 80) {
                $this->warn("⚠️  CẢNH BÁO: Sử dụng {$usagePercent}% kết nối database!");
                Log::warning("Database connection usage high: {$usagePercent}%");
            } else {
                $this->info("✅ Tình trạng kết nối ổn định");
            }

            // Hiển thị các kết nối đang chạy
            $processList = DB::select("SHOW PROCESSLIST");
            $this->info("\n=== CÁC KẾT NỐI ĐANG CHẠY ===");
            $this->table(
                ['ID', 'User', 'Host', 'DB', 'Command', 'Time', 'State', 'Info'],
                collect($processList)->map(function ($process) {
                    return [
                        $process->Id,
                        $process->User,
                        $process->Host,
                        $process->db ?? 'NULL',
                        $process->Command,
                        $process->Time,
                        $process->State,
                        substr($process->Info ?? '', 0, 50) . '...'
                    ];
                })->toArray()
            );

            return 0;

        } catch (\Exception $e) {
            $this->error("Lỗi khi kiểm tra kết nối: " . $e->getMessage());
            Log::error("CheckDatabaseConnections failed: " . $e->getMessage());
            return 1;
        }
    }
}
