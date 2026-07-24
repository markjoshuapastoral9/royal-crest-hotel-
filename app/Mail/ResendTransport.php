<?php

namespace App\Mail;

use Resend;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class ResendTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $resend = Resend::client(config('services.resend.key'));
        
        $resend->emails->send([
            'from' => $email->getFrom()[0]->toString(),
            'to' => array_map(fn($addr) => $addr->toString(), $email->getTo()),
            'subject' => $email->getSubject(),
            'html' => $email->getHtmlBody(),
            'text' => $email->getTextBody(),
        ]);
    }

    public function __toString(): string
    {
        return 'resend';
    }
}
