<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index()
    {
        $user = $this->em->getRepository(User::class)->findAll();
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