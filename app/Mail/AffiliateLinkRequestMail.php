<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AffiliateLinkRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $affiliateLink;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($affiliateLink, $user)
    {
        $this->affiliateLink = $affiliateLink;
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
                    ->with(['affiliateLink' => $this->affiliateLink, 'user' => $this->user]);
    }
}
