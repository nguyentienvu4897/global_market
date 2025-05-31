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

    /**
     * @param $user
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Thông báo đăng ký bán hàng thành công';

        return $this->subject($title)->view('site.mails.seller-request-success', ['data' => $this->data]);
    }
}
