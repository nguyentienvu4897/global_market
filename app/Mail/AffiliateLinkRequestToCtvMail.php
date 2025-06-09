<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AffiliateLinkRequestToCtvMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ctv_user;
    public $object;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ctv_user, $object)
    {
        $this->ctv_user = $ctv_user;
        $this->object = $object;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Khách hàng đề xuất sản phẩm mới tại globalmarket.com.vn!')
                    ->view('site.mails.affiliate_link_request_to_ctv')
                    ->with(['ctv_user' => $this->ctv_user, 'object' => $this->object]);
    }
}
