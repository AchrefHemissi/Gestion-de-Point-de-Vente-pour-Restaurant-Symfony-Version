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
    public function sendEmail(string $recipient,string $subject,string $message,string $from): bool
    {
        try {
            $email = (new Email())
                ->from($from)
                ->to($recipient)
                ->subject($subject)
                ->text($message);

            $this->mailer->send($email);
            return true;

        } catch (TransportExceptionInterface $e) {

            return false;
        }
    }
}