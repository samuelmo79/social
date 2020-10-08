<?php


namespace App\Controller;

use App\Entity\Amizade;
use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\StatusSolicitacaoEnum;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;


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

        /* @var User $usuario */
        $usuario = $this->getUser();

        $amizadeSolicitante = new Amizade();
        $amizadeSolicitado = new Amizade();

        $amizadeSolicitante->setUsuario($solicitacao->getSolicitante());
        $amizadeSolicitante->setAmigo($solicitacao->getSolicitado());
        $amizadeSolicitante->addSolicitacao($solicitacao);

        $amizadeSolicitado->setUsuario($solicitacao->getSolicitado());
        $amizadeSolicitado->setAmigo($solicitacao->getSolicitante());
        $amizadeSolicitado->addSolicitacao($solicitacao);

        $entityManager->persist($amizadeSolicitado);
        $entityManager->persist($amizadeSolicitante);
        $entityManager->flush();

        dd($amizadeSolicitante, $amizadeSolicitado);

        try {

        } catch (Throwable $exception) {
            die();
        }


    }

}