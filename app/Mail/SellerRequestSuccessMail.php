<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
class SellerRequestSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $user;

    /**
     * @param $user
     * @param $data
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Thông báo đăng ký cộng tác viên thành công';

        return $this->subject($title)->view('site.mails.seller-request-success', ['data' => $this->data, 'user' => $this->user]);
    }
}
