<?php

namespace App\Controller;

use App\Entity\Solicitacao;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SolicitacaoController extends AbstractController
{
    /**
     * @Route("/solicita_amizade/{id}", name="solicita_amizade")
     * @param User $solicitado
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(User $solicitado)
    {
        $solicitacao = new Solicitacao();

        /** @var User $user */
        $user = $this->getUser();

        if($solicitado ===  $user)  {
            $this->addFlash('warning', 'Não é possível enviar uma solicitação de amizade para si !');
            return $this->redirectToRoute('amigos');
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $solicitacao->setSolicitado($solicitado);
            $solicitacao->setSolicitante($user);
            $solicitacao->setTipo('Amizade');
            $solicitacao->setStatus(1);
            $entityManager->persist($solicitacao);
            $entityManager->flush();
            $this->addFlash('success', 'Solicitação enviada !');

        } catch (\Throwable $e) {
            $this->addFlash('danger', 'Já foi enviada solicitação para esse usuário !');
            return $this->redirectToRoute('amigos');
        }

        return $this->redirectToRoute('amigos');
    }

}
