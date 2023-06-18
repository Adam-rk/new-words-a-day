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
            $body .= "<div>
            <h2 style='font-size: 24px; font-weight: bold; margin: 0 0 2px 0;' >".$word["word"]."</h2></br>
            <h4 style='font-size: 18px; margin: 0 0 2px 0;'>".$language."</h4></br>";
            foreach ($word["definitions"] as $definition) {
                $body .= "<p style='font-style: italic; margin: 0 0 2px 0;'>".$definition."</p></br></div>";
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