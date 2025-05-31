<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
class SellerRequestMail extends Mailable
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
        $title = 'Thông báo yêu cầu đăng ký bán hàng #';
        $url = URL::signedRoute('front.seller-approve', ['id' => $this->data->id]);

        return $this->subject($title . $this->data->email)->view('site.mails.seller-request', ['data' => $this->data, 'url' => $url]);
    }
}
