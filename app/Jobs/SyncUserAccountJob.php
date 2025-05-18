<?php

namespace App\Jobs;

use App\Services\SyncUserAccountService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SyncUserAccountFailedNotification;

class SyncUserAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $syncUserAccountService = new SyncUserAccountService();
            $syncUserAccountService->sendSyncUserAccount($this->user);
        } catch (\Exception $e) {
            \Log::error('SyncUserAccountJob failed: ' . $e->getMessage());
            Notification::route('mail', 'vudev4897@gmail.com')
                ->notify(new SyncUserAccountFailedNotification($this->user, $e->getMessage()));
        }
    }
}
