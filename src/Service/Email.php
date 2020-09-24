<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class Email
{
    private $mailer;
    private $view;
    private $emailFrom;
    private $emailFromNome;

    public function __construct(Swift_Mailer $mailer, Environment $view, $emailFrom, $emailFromNome)
    {
        $this->mailer = $mailer;
        $this->view = $view;
        $this->emailFrom = $emailFrom;
        $this->emailFromNome = $emailFromNome;
    }
    public function enviar(string $assunto, array $destinatario, string $template, array $params)
    {
        $mensagem = (new Swift_Message($assunto))
            ->setFrom([$this->emailFrom => $this->emailFromNome])
            ->setTo($destinatario)
            ->setBody($this->view->render($template, $params), 'text/html');

        $this->mailer->send($mensagem);
    }
}