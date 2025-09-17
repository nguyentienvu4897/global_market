<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseConnectionService;

class CleanupDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:cleanup-connections {--force : Force cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dọn dẹp các kết nối database không cần thiết';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Bắt đầu kiểm tra và dọn dẹp kết nối database...");

        // Kiểm tra health trước
        $health = DatabaseConnectionService::checkConnectionHealth();

        if ($health['status'] !== 'healthy') {
            $this->error("Database không khỏe mạnh. Không thể thực hiện cleanup.");
            return 1;
        }

        $this->info("Tình trạng database: {$health['status']}");
        $this->info("Kết nối hiện tại: {$health['current_connections']}/{$health['max_connections']} ({$health['usage_percent']}%)");

        // Hỏi xác nhận nếu không có --force
        if (!$this->option('force')) {
            if (!$this->confirm('Bạn có muốn tiếp tục dọn dẹp kết nối?')) {
                $this->info('Hủy bỏ thao tác.');
                return 0;
            }
        }

        // Thực hiện cleanup
        $killedCount = DatabaseConnectionService::cleanupIdleConnections();

        if ($killedCount > 0) {
            $this->info("✅ Đã dọn dẹp {$killedCount} kết nối không cần thiết.");
        } else {
            $this->info("ℹ️  Không có kết nối nào cần dọn dẹp.");
        }

        // Kiểm tra lại sau cleanup
        $healthAfter = DatabaseConnectionService::checkConnectionHealth();
        $this->info("Sau cleanup - Kết nối: {$healthAfter['current_connections']}/{$healthAfter['max_connections']} ({$healthAfter['usage_percent']}%)");

        return 0;
    }
}
