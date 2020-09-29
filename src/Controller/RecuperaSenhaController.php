<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EmailResetType;
use App\Form\ResetaSenhaType;
use App\Service\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecuperaSenhaController extends AbstractController
{
    /**
     * @Route("/recupera_senha", name="usuario_esqueceu_senha")
     * @param Request $request
     * @param Email $emailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, Email $emailer)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EmailResetType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $usuario */
            $usuario = $em->getRepository(User::class)->findOneBy(['email' => $form->getData()['email']]);

            if ($usuario != null) {
                $tokengerado = uniqid();
                $usuario->setTokenResetPassword($tokengerado);
                $em->persist($usuario);
                $em->flush();
                $this->enviarLink($usuario, $emailer);
                $this->addFlash("success", "Foi enviado para seu e-mail o link para redefinição de senha.");
            } else {
                $this->addFlash("warning", "O email informado não está correto ou não está cadastrado.");
                return $this->redirectToRoute('usuario_esqueceu_senha');
            }
        }

        return $this->render('emails/usuario/email_recuperacao.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function enviarLink(User $usuario, Email $mailer)
    {
        $assunto = $usuario->getDadosPessoais()->getNome() . ", Redefina a sua senha";
        $destinatario = [$usuario->getEmail() => $usuario->getDadosPessoais()->getNome()];
        $params = [
            'nome' => $usuario->getDadosPessoais()->getNome(),
            'token' => $usuario->getTokenResetPassword()
        ];

        $mailer->enviar(
            $assunto,
            $destinatario,
            "emails/usuario/recupera_senha.html.twig",
            $params
        );
    }

    /**
     * @Route("/redefinir_senha", name="resetar_senha_token")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPasswordToken(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $token = $request->query->get('token');
        if ($token != null) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository(User::class)->findOneBy(['tokenResetPassword' => $token]);

            if ($usuario != null) {
                $form = $this->createForm(ResetaSenhaType::class, $usuario);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $plainPassword = $form->getData()->getSenhaPura();
                    $encoded = $encoder->encodePassword($usuario, $plainPassword);
                    $usuario->setPassword($encoded);
                    $usuario->setTokenResetPassword(null);
                    $em->persist($usuario);
                    $em->flush();

                    $this->addFlash("success", "Senha atualizada com sucesso!");
                    return $this->redirectToRoute('app_login');
                }
                return $this->render('emails/usuario/redefine_senha.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $this->addFlash("warning", "Operação inválida");
            return $this->redirectToRoute('app_login');
        }
    }

}
