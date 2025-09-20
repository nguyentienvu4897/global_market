<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ManageAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache {action : clear|warm|status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quản lý cache app (clear, warm, status)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'clear':
                return $this->clearCache();
            case 'warm':
                return $this->warmCache();
            case 'status':
                return $this->showCacheStatus();
            default:
                $this->error('Action không hợp lệ. Sử dụng: clear, warm, status');
                return 1;
        }
    }

    private function clearCache()
    {
        $this->info('Bắt đầu xóa cache app...');

        $cacheKeys = [
            'app_config',
            'app_config_permanent',
            'app_tag_search',
            'app_tag_search_all',
            'app_banners'
        ];

        $clearedCount = 0;
        foreach ($cacheKeys as $key) {
            if (Cache::forget($key)) {
                $clearedCount++;
                $this->info("✅ Đã xóa cache: {$key}");
            }
        }

        $this->info("Hoàn thành! Đã xóa {$clearedCount} cache keys.");
        return 0;
    }

    private function warmCache()
    {
        $this->info('Bắt đầu làm nóng cache app...');

        try {
            // Warm config cache
            $config = \App\Model\Admin\Config::getCachedConfig();
            $this->info("✅ Config cache đã được làm nóng");

            // Warm other caches
            Cache::remember('app_tag_search', 7200, function () {
                return \App\Model\Admin\Tag::where('type', 10)->inRandomOrder()->limit(3)->get();
            });
            $this->info("✅ Tag search cache đã được làm nóng");

            Cache::remember('app_banners', 3600, function () {
                return \App\Model\Admin\Banner::with(['image'])->get();
            });
            $this->info("✅ Banners cache đã được làm nóng");

            $this->info("Hoàn thành! Cache đã được làm nóng.");
            return 0;

        } catch (\Exception $e) {
            $this->error("Lỗi khi làm nóng cache: " . $e->getMessage());
            return 1;
        }
    }

    private function showCacheStatus()
    {
        $this->info('=== TRẠNG THÁI CACHE APP ===');

        $cacheKeys = [
            'app_config' => 'Config (24h)',
            'app_config_permanent' => 'Config (permanent)',
            'app_tag_search' => 'Tag search (2h)',
            'app_tag_search_all' => 'Tag search all (2h)',
            'app_banners' => 'Banners (1h)'
        ];

        foreach ($cacheKeys as $key => $description) {
            $exists = Cache::has($key);
            $status = $exists ? '✅ Có' : '❌ Không có';
            $this->line("{$description}: {$status}");
        }

        return 0;
    }
}
