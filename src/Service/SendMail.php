<?php

namespace App\Service;

class SendMail
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendAnEmail($subject, $mailFrom, $mailTo, $body)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($mailFrom)
            ->setTo($mailTo)
            ->setBody(
                $body
            );

        $this->mailer->send($message);
    }
}
