<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $senhaEncriptada = $encoder->encodePassword($user, $user->getSenhaPura());
            $user->setPassword($senhaEncriptada);
            $entityManager = $this->getDoctrine()->getManager();
            $user->setAtivo(false);
            $user->setOnline(false);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Uauário cadastrado com sucesso!');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registro/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
