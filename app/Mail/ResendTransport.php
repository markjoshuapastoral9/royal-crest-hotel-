<?php

namespace App\Mail;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class ResendTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $to = [];
        foreach ($email->getTo() as $address) {
            $to[] = $address->getAddress();
        }
        
        $from = $email->getFrom()[0]->getAddress();
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.resend.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.resend.com/emails', [
            'from' => $from,
            'to' => $to,
            'subject' => $email->getSubject(),
            'html' => $email->getHtmlBody(),
        ]);
        
        if ($response->failed()) {
            throw new \Exception('Resend API error: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'resend';
    }
}
