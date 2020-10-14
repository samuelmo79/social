<?php

namespace App\Controller;

use App\Entity\Amizade;
use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmigosController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/amigos", name="amigos", methods={"GET"})
     * @Template("amigos/index.html.twig")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $pesquisarAmigos = $request->get('pesquisar_amigos');

        $user = $this->em->getRepository(User::class)
            ->findByAmigos($pesquisarAmigos, $this->getUser());

        $page = $request->query->getInt('page', 1);
        $user = $paginator->paginate($user, $page, 20);

        return [
            'user' => $user,
        ];
    }

    /**
     * @Route("/amigos/{id}", name="amigos_perfil", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function perfilPublico(User $user)
    {
        $solicitados = $user->getSolicitados()->toArray();
        $solicitacaoRecebida = false;

        $idUsuario = $this->getUser()->getId();

        if ($idUsuario == $user->getId()) {
            return $this->redirectToRoute('perfil');
        }

        $solicitadosPorUsuario = array_filter($solicitados, function ($solicitados) use ($idUsuario) {
            return $solicitados->getSolicitante()->getId() == $idUsuario &&
                $solicitados->getTipo() == TipoSolicitacaoEnum::AMIZADE;
        });

        if($solicitadosPorUsuario == []) {
            $solicitacoes = $user->getSolicitacaos()->toArray();
            $solicitadosPorUsuario = array_filter($solicitacoes, function ($solicitacoes) use ($idUsuario) {
                return $solicitacoes->getSolicitado()->getId() == $idUsuario &&
                    $solicitacoes->getTipo() == TipoSolicitacaoEnum::AMIZADE;
            });
            if ($solicitadosPorUsuario != []) {
                $solicitacaoRecebida = true;
            }
        }

        return $this->render('amigos/amigoPerfil.html.twig', [
            'controller_name' => 'RecadosController',
            'user' => $user,
            'solicitacao' => $solicitadosPorUsuario != [] ? current($solicitadosPorUsuario) : null,
            'solicitacaoRecebida' => $solicitacaoRecebida
        ]);
    }

}
