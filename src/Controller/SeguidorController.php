<?php


namespace App\Controller;

use App\Entity\Seguidor;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class SeguidorController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/seguir/{id}", name="seguir_usuario", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function index(User $user)
    {
        /** @var User $usuarioLogado */
        $usuarioLogado = $this->getUser();
        $seguidor = new Seguidor();

        try {
            $seguidor->setUsuarioSeguidor($usuarioLogado);
            $seguidor->setUsuarioSeguido($user);

            $this->em->persist($seguidor);
            $this->em->flush();
        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
            return new JsonResponse(['success' => false, 'seguidor' => ['id' => $seguidor->getId()]]);
        }

        return new JsonResponse(['success' => true, 'seguidor' => ['id' => $seguidor->getId()]]);
    }

    /**
     * @Route("/unfollow/{id}", name="deseguir_usuario", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function unfollow(User $user)
    {
        /** @var User $usuarioLogado */
        $usuarioLogado = $this->getUser();
        $seguidor = $this->em->getRepository(Seguidor::class)->findOneBy(
            [
                'usuarioSeguidor' => $usuarioLogado,
                'usuarioSeguido' => $user
            ]);

        try {

            $this->em->remove($seguidor);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
            return new JsonResponse(['success' => false, 'seguidor' => ['id' => $seguidor->getId()]]);
        }

        return new JsonResponse(['success' => true, 'seguidor' => ['id' => $seguidor->getId()]]);
    }


}