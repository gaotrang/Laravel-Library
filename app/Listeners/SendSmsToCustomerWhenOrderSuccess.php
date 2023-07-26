<?php

namespace App\Listeners;

use App\Events\OrderSuccessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsToCustomerWhenOrderSuccess
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSuccessEvent $event): void
    {
        // $order = $event->order;
        //     //Send sms to customer
        //     $receiverNumber = '+84334400700';
        //     $client = new \Twilio\Rest\Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        //     $client->messages->create($receiverNumber, [
        //         'from' => env('TWILIO_PHONE_NUMBER'),
        //         'body' => 'YUP'
        //     ]);
    }
}
