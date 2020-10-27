<?php

namespace App\Controller;

use App\Entity\CurtidaPost;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class PostController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/curte_post/{id}", name="curte_postagem")
     * @param Post $post
     * @return RedirectResponse
     */
    public function curtePostagem(Post $post)
    {
        $curtidaPost = new CurtidaPost();

        /** @var User $usuario */
        $usuario = $this->getUser();
        $curtidaPost->setUsuario($usuario);
        $curtidaPost->setPostagem($post);

        try {
            $this->em->persist($curtidaPost);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }

        return new JsonResponse(['success' => true, 'post' => ['id' => $post->getId()]]);
    }

    /**
     * @Route("/descurte_post/{id}", name="descurte_postagem")
     * @param Post $post
     * @return RedirectResponse
     */
    public function descurtePostagem(Post $post)
    {
        $curtidas = $post->getCurtidaPosts()->toArray();

        /** @var User $usuario */
        $usuario = $this->getUser();

        $idUsuario = $usuario->getId();
        $idPostagem = $post->getId();

        $curtidaPorMim = current(array_filter($curtidas, function ($curtidas) use ($idUsuario, $idPostagem) {
            return $curtidas->getUsuario()->getId() == $idUsuario && $curtidas->getPostagem()->getId() == $idPostagem ;
        }));

        try {
            $this->em->remove($curtidaPorMim);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }

        return new JsonResponse(['success' => true, 'post' => ['id' => $post->getId()]]);
    }}
