<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     */
    public function perfilPublico(User $user)
    {
        return $this->render('amigos/amigoPerfil.html.twig', [
            'controller_name' => 'RecadosController',
            'user' => $user,
        ]);
    }
}
