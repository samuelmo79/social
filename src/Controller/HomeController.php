<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request)
    {
        $post = $this->em->getRepository(Post::class)
            ->findBy(array(), array('dataCadastro' => 'DESC'));

        $eventos = $this->em->getRepository(Evento::class)->findAll();

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
}
