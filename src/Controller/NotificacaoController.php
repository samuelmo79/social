<?php

namespace App\Controller;

use App\Entity\Notificacao;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificacaoController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager)
    {
        $notificacoes = $entityManager->getRepository(Notificacao::class)
            ->findBy(array(), array('dataNotificacao' => 'DESC'), '5');

        return $this->render('notificacao/index.html.twig', [
            'notificacoes' => $notificacoes,
        ]);
    }

    /**
     * @Route("/notificacoes", name="notificacao_mobile")
     */
    public function indexMobile(EntityManagerInterface $entityManager)
    {
        $notificacoes = $entityManager->getRepository(Notificacao::class)
            ->findBy(array(), array('dataNotificacao' => 'DESC'));

        return $this->render('notificacao/indexMobile.html.twig', [
            'notificacoes' => $notificacoes,
        ]);
    }
}
