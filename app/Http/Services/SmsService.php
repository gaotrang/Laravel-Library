<?php 
declare(strict_types=1);
namespace App\Http\Servies;

class SmsService{
        public function send(string $phoneNumber,string $message): void{
        $receiverNumber = $phoneNumber;
        $client = new \Twilio\Rest\Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        $client->messages->create($receiverNumber, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $message
        ]);
    }
}
?>