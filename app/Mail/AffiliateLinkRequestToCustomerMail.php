<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AffiliateLinkRequestToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $object;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $object, $product)
    {
        $this->customer = $customer;
        $this->object = $object;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận yêu cầu affiliate link tại globalmarket.com.vn!')
                    ->view('site.mails.affiliate_link_success_to_customer')
                    ->with(['customer' => $this->customer, 'object' => $this->object, 'product' => $this->product]);
    }
}
