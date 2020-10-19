<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Post;
use App\Entity\PostComentario;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class HomeController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $post = $this->em->getRepository(Post::class)
            ->findBy(array(), array('dataCadastro' => 'DESC'));

        $eventos = $this->em->getRepository(Evento::class)
            ->findBy(array(), array('dataCadastro' => 'DESC'), 3);

        $cadastraPost = new Post();
        $form = $this->createForm(PostType::class, $cadastraPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $cadastraPost->setAutor($this->getUser());
            $entityManager->persist($cadastraPost);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'eventos' => $eventos,
        ]);
    }

    /**
     * @Route("/novo_comentario", name="cadastra_comentario")
     * @param Request $request
     * @return RedirectResponse
     */
    public function novo_comentario(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $this->em->getRepository(Post::class)
            ->findOneBy(['id' => $request->get('postId')]);
        $comentario = new PostComentario();
        $comentario->setPost($post);
        $comentario->setComentario($request->get('comentario'));

        /** @var User $usuario */
        $usuario = $this->getUser();
        $comentario->setUser($usuario);

        $entityManager->persist($comentario);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/edita_postagem/{id}", name="edita_postagem")
     * @Security("user.getId() == post.getAutor().getId()")
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function editaPostagem(Request $request, Post $post)
    {
        $post->setConteudo($request->get('postagemConteudo'));

        try {
            $this->em->persist($post);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/deleta_postagem/{id}", name="deleta_postagem")
     * @Security("user.getId() == post.getAutor().getId()")
     * @param Post $post
     * @return RedirectResponse
     */
    public function deletaPostagem(Post $post)
    {
        try {
            $this->em->remove($post);
            $this->em->flush();
        } catch(Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/deleta_comentario/{id}", name="deleta_comentario")
     * @Security("user.getId() == postComentario.getUser().getId()")
     * @param PostComentario $postComentario
     * @return RedirectResponse
     */
    public function deletaComentario(PostComentario $postComentario)
    {
//        dd($postComentario);
        try {
            $this->em->remove($postComentario);
            $this->em->flush();
        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }
        return $this->redirectToRoute('home');
    }
}
