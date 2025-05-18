<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;

    /**
     * @param $link
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Liên kết xác minh email';

        return $this->subject($title)->view('site.mail-verify.template-email', ['link' => $this->link]);
    }
}
