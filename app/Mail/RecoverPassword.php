<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecoverPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $new_password;

    /**
     * @param $user
     * @param $new_password
     */
    public function __construct($user, $new_password)
    {
        $this->user = $user;
        $this->new_password = $new_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Thông báo thay đổi mật khẩu #';

        return $this->subject($title . $this->user->email)->view('site.mails.recover-password', ['user' => $this->user, 'new_password' => $this->new_password]);
    }
}
