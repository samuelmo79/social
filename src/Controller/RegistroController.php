<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\SecurityAuthenticator;
use App\Service\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param Email $mailer
     * @return Response
     */
    public function new(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        Email $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = uniqid();
            $senhaEncriptada = $encoder->encodePassword($user, $user->getSenhaPura());
            $user->setPassword($senhaEncriptada);
            $entityManager = $this->getDoctrine()->getManager();
            $user->setAtivo(false);
            $user->setOnline(false);
            $user->setTokenPassword($token);
            $this->enviarEmail($user, $mailer);
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

    /**
     * @Route("/ativa", name="ativa_conta")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ativaConta(Request $request)
    {
        $token = $request->query->get('token');
        if ($token != null) {
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository(User::class)->findOneBy(['tokenPassword' => $token]);

            if ($user != null) {
                $user->setAtivo(true);
                $user->setTokenPassword(null);
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_login');
            }
        }
    }

    private function enviarEmail(User $user, Email $mailer)
    {
        $assunto = $user->getDadosPessoais()->getNome() . ", Ative sua conta ";
        $destinatario = [$user->getEmail() => $user->getEmail()];
        $params = [
            'nome' => $user->getDadosPessoais()->getNome(),
            'token' => $user->getTokenPassword()
        ];

        $mailer->enviar(
            $assunto,
            $destinatario,
            "emails/usuario/ativa_conta.html.twig",
            $params
        );
    }

}
