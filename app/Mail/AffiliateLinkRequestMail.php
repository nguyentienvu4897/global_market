<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AffiliateLinkRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $arrGenerateLink;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arrGenerateLink, $user)
    {
        $this->arrGenerateLink = $arrGenerateLink;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông báo! Yêu cầu cấp link liên kết affiliate')
                    ->view('site.mails.affiliate_link_request')
                    ->with(['arrGenerateLink' => $this->arrGenerateLink, 'user' => $this->user]);
    }
}
