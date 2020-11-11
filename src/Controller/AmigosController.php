<?php

namespace App\Controller;

use App\Entity\Amizade;
use App\Entity\Bloqueio;
use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\StatusSolicitacaoEnum;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

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
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return array
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

        /** @var User $userLogado */
        $userLogado = $this->getUser();

        if ($user->recebeuBloqueioDe($userLogado) ||
            $user->efetuouBloqueio($userLogado)) {
            $this->addFlash("warning", "Esse perfil não está disponível no momento");
            return $this->redirectToRoute("amigos");
        }

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

    /**
     * @Route("/meus-amigos", name="meus_amigos")
     */
    public function meusAmigos()
    {
        $meusAmigos = $this->em->getRepository(Amizade::class)->findBy(['usuario' => $this->getUser()]);

        return $this->render('amigos/meusAmigos.html.twig', [
            'meusAmigos' => $meusAmigos,
        ]);
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

    /**
     * @Route("/bloqueio-amigo/{id}", name="bloqueio")
     * @param User $bloqueado
     * @return RedirectResponse
     */
    public function bloqueioAmigo(User $bloqueado)
    {
        /** @var User $usuarioLogado */
        $usuarioLogado = $this->getUser();
        $bloqueio = new Bloqueio();

        $bloqueio->setUsuarioBloqueador($usuarioLogado);
        $bloqueio->setUsuarioBloqueado($bloqueado);

        $amizadeUsuarioparaBloqueado = $this->em->getRepository(Amizade::class)->findOneBy([
            'usuario' => $usuarioLogado,
            'amigo' => $bloqueado
        ]);

        $solicitacaoAmizadeUsuarioParaBloqueado = $this->em->getRepository(Solicitacao::class)->findOneBy([
            'solicitante' => $usuarioLogado,
            'solicitado' => $bloqueado
        ]);

        $amizadeBloqueadoParaUsuario = $this->em->getRepository(Amizade::class)->findOneBy([
            'usuario' => $bloqueado,
            'amigo' => $usuarioLogado
        ]);

        $solicitacaoAmizadeBloqueadoParaUsuario = $this->em->getRepository(Solicitacao::class)->findOneBy([
            'solicitante' => $bloqueado,
            'solicitado' => $usuarioLogado
        ]);

        try {
            if ($bloqueado->getId() == $usuarioLogado->getId()) {
                throw new Exception();
            }
            $this->em->remove($amizadeUsuarioparaBloqueado);
            $this->em->remove($amizadeBloqueadoParaUsuario);

            if($solicitacaoAmizadeBloqueadoParaUsuario != null)
                $this->em->remove($solicitacaoAmizadeBloqueadoParaUsuario);

            if($solicitacaoAmizadeUsuarioParaBloqueado != null)
                $this->em->remove($solicitacaoAmizadeUsuarioParaBloqueado);

            $this->em->persist($bloqueio);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }

        return $this->redirectToRoute('amigos');
    }
}
