<?php

namespace App\Services;

use App\Http\Traits\ResponseTrait;
use App\Notifications\SyncUserAccountFailedNotification;
use App\Notifications\SyncUserAccountSuccessNotification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Notification;

class SyncUserAccountService
{
    use ResponseTrait;
    protected $apiToken;
    protected $apiUrl;
    protected $client;

    public function __construct()
    {
        $this->apiToken = config('sync_user.api_token');
        $this->apiUrl = config('sync_user.api_url');
        $this->client = new Client();
    }

    public function sendSyncUserAccount($user)
    {
        try {
            $response = $this->client->post($this->apiUrl . '/api/sync-user-account', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,
                ],
                'form_params' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'account_name' => $user->account_name,
                    'phone_number' => $user->phone_number,
                    'password' => $user->password, // đã được bcrypt
                    'status' => $user->status,
                    'type' => $user->type,
                    'parent_id' => $user->parent_id,
                    'address' => $user->address,
                    'bank_account_number' => $user->bank_account_number,
                    'bank_account_name' => $user->bank_account_name,
                    'bank_name' => $user->bank_name,
                ],
            ]);

            // Gửi email để thông báo
            if ($response->getStatusCode() == 200) {
                Notification::route('mail', 'nguyentienvu4897@gmail.com')
                    ->notify(new SyncUserAccountSuccessNotification($user));
            } else {
                Notification::route('mail', 'nguyentienvu4897@gmail.com')
                    ->notify(new SyncUserAccountFailedNotification($user, $response->getBody()));
            }
        } catch (\Exception $e) {
            \Log::error('Sync user failed: ' . $e->getMessage());
            Notification::route('mail', 'nguyentienvu4897@gmail.com')
                ->notify(new SyncUserAccountFailedNotification($user, $e->getMessage()));
        }
    }
}
