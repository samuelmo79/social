<?php

namespace App\Controller;

use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\StatusSolicitacaoEnum;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/solicitacao")
 */
class SolicitacaoController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/amizade/{id}", name="solicita_amizade")
     * @param User $solicitado
     * @param Request $request
     * @return Response
     */
    public function index(User $solicitado, Request $request)
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

        } catch (Throwable $e) {
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

        $solicitacoesEnviadas = $this->em->getRepository(Solicitacao::class)
            ->findBy(['solicitante' => $this->getUser(), 'status' => StatusSolicitacaoEnum::PENDENTE]);

        return $this->render('solicitacao/index.html.twig', [
            'solicitacoes' => $solicitacoes,
            'solicitacoesEnviadas' => $solicitacoesEnviadas,
        ]);
    }

    /**
     * @Route("/excluir_solicitacao/{id}", name="deleta_solicitacao")
     * @Security("user.getId() == solicitacao.getSolicitado().getId()")
     * @param Solicitacao $solicitacao
     * @return RedirectResponse
     */
    public function excluirSolicitacao(Solicitacao $solicitacao)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $entityManager->remove($solicitacao);
            $entityManager->flush();
            $this->addFlash('success','Solicitação removida com sucesso!');
        } catch (Throwable $e) {
            $this->addFlash('danger','Essa solicitação não pode ser atendida!');
        }
        return $this->redirectToRoute('solicitacoes');
    }
}
