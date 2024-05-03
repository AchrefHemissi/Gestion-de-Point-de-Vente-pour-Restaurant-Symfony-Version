<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMailFromAdminService
{
     public function __construct(private MailerInterface $mailer){}


    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(mixed $formData): void
    {

        $recipient = $formData['recipient'];
        $subject = $formData['subject'];
        $message = $formData['message'];

        $email = (new Email())
                ->from('gl.icious.symfonyteam@gmail.com')
                ->to($recipient)
                ->subject($subject)
                ->text($message);

        $this->mailer->send($email);

    }
}