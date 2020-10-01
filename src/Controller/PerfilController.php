<?php

namespace App\Controller;

use App\Entity\Notificacao;
use App\Entity\User;
use App\Form\EditarDadosPessoaisType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PerfilController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/perfil", name="perfil")
     * @param UserInterface $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserInterface $user)
    {
        $atividades = $this->em->getRepository(Notificacao::class)->getQueryNotificacao($this->getUser());

        return $this->render('perfil/index.html.twig', [
            'user' => $user,
            'atividades' => $atividades,
        ]);
    }

    /**
     * @Route("/perfil/editar", name="editar_perfil")
     * @Template("perfil/editarPerfil.html.twig")
     * @param UserInterface $user
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editarPerfil(UserInterface $user, Request $request)
    {
        $perfil = $this->em->getRepository(User::class)->find($user);
        $form = $this->createForm(EditarDadosPessoaisType::class, $perfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $perfil->getLocalizacao()->setPais(Countries::getName($perfil->getLocalizacao()->getPais()));
            $this->em->persist($perfil);
            $this->em->flush();

            $this->addFlash("success", "Perfil atualizado com sucesso!");
            return $this->redirectToRoute('editar_perfil');
        }

        return [
            'user' => $user,
            'form' => $form->createView(),
        ];
    }
}
