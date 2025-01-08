<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawMoney extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * @param $user
     * @param $data
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Thông báo yêu cầu quyết toán hoa hồng #';

        return $this->subject($title . $this->user->name)->view('site.mails.withdraw-money', ['user' => $this->user, 'data' => $this->data]);
    }
}
