<?php

namespace App\Controller;

use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\StatusSolicitacaoEnum;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SolicitacaoController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

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
            $solicitacao->setTipo(TipoSolicitacaoEnum::AMIZADE);
            $solicitacao->setStatus(StatusSolicitacaoEnum::PENDENTE);
            $entityManager->persist($solicitacao);
            $entityManager->flush();
            $this->addFlash('success', 'Solicitação enviada !');

        } catch (\Throwable $e) {
            $this->addFlash('danger', 'Já foi enviada solicitação para esse usuário !');
            return $this->redirectToRoute('amigos');
        }

        return $this->redirectToRoute('amigos');
    }

    /**
     * @Route("/solicitacoes", name="solicitacoes")
     */
    public function solicitacoes()
    {
        $solicitacoes = $this->em->getRepository(Solicitacao::class)
            ->findBy(['solicitado' => $this->getUser(), 'status' => StatusSolicitacaoEnum::PENDENTE]);

        return $this->render('solicitacao/index.html.twig', [
            'solicitacoes' => $solicitacoes,
        ]);
    }
}
