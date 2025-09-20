<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa cache của app (config, banners, tags)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Bắt đầu xóa cache app...');

        // Xóa các cache keys
        $cacheKeys = [
            'app_config',
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
}
