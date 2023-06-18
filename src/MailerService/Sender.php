<?php

namespace App\MailerService;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Sender
{
    public function __construct(
        private readonly MailerInterface $mailer
    )
    {
    }

    public function sendEmail(array $wordsArray) {

        $body = "";

        foreach ($wordsArray as $language => $word) {
            $body .= "<h1 style='font-size: 24px; font-weight: bold;'>".$word["word"]."</h1></br><h2 style='font-size: 18px;'>".$language."</h2></br>";
            foreach ($word["definitions"] as $definition) {
                $body .= "<h3 style='font-style: italic;'>".$definition."</h3></br>";
            }
        }

        $email = (new Email())
            ->from('newwordaday@adamrafik.com')
            ->to('adam.rfk2@gmail.com')
            ->subject('Les mots du jour sont arrivés !')
            ->html($body);

        $this->mailer->send($email);

        return $body;
    }
}