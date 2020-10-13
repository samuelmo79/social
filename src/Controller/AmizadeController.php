<?php


namespace App\Controller;

use App\Entity\Amizade;
use App\Entity\Solicitacao;
use App\Enum\StatusSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


class AmizadeController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/nova_amizade/{id}", name="aceita_solicitacao", methods={"GET"})
     * @Security("user.getId() == solicitacao.getSolicitado().getId()")
     * @param Solicitacao $solicitacao
     * @return RedirectResponse
     */
    public function aceitaSolicitacaoAmizade(Solicitacao $solicitacao)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $amizadeSolicitante = new Amizade();
        $amizadeSolicitado = new Amizade();
        $solicitacao->setStatus(StatusSolicitacaoEnum::ACEITO);

        $amizadeSolicitante->setUsuario($solicitacao->getSolicitante());
        $amizadeSolicitante->setAmigo($solicitacao->getSolicitado());
        $amizadeSolicitante->addSolicitacao($solicitacao);

        $amizadeSolicitado->setUsuario($solicitacao->getSolicitado());
        $amizadeSolicitado->setAmigo($solicitacao->getSolicitante());
        $amizadeSolicitado->addSolicitacao($solicitacao);

        $entityManager->persist($amizadeSolicitado);
        $entityManager->persist($amizadeSolicitante);
        $entityManager->persist($solicitacao);
        $entityManager->flush();

        $this->addFlash('success','Solicitação de amizade aceita!');
        return $this->redirectToRoute('solicitacoes');
    }

}