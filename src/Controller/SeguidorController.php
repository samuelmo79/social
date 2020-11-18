<?php


namespace App\Controller;

use App\Entity\Amizade;
use App\Entity\Bloqueio;
use App\Entity\Seguidor;
use App\Entity\Solicitacao;
use App\Entity\User;
use App\Enum\StatusSolicitacaoEnum;
use App\Enum\TipoSolicitacaoEnum;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

        try {
            $seguidor = new Seguidor();
            $seguidor->setUsuarioSeguidor($usuarioLogado);
            $seguidor->setUsuarioSeguido($user);

            $this->em->persist($seguidor);
            $this->em->flush();

        } catch (Throwable $exception) {
            $this->addFlash('warning', 'Sua solicitação não pode ser processada !');
        }

        return $this->redirectToRoute('');
    }

}