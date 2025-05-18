<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SyncUserAccountFailedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $error;

    public function __construct($user, $error)
    {
        $this->user = $user;
        $this->error = $error;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('❌ Đồng bộ tài khoản thất bại')
            ->line("Tài khoản: {$this->user->email}")
            ->line("Tên đăng nhập: {$this->user->account_name}")
            ->line("Lỗi: {$this->error}")
            ->line('Hệ thống vẫn đã đăng ký thành công tại website A.');
    }
}
