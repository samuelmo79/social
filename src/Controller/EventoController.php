<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\EventoParticipante;
use App\Entity\EventoRecado;
use App\Form\EventoRecadoType;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evento")
 */
class EventoController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="evento_index", methods={"GET"})
     */
    public function index(EventoRepository $eventoRepository): Response
    {
        return $this->render('evento/index.html.twig', [
            'eventos' => $eventoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evento_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evento = new Evento();
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evento);
            $entityManager->flush();

            return $this->redirectToRoute('evento_index');
        }

        return $this->render('evento/new.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evento_show", methods={"GET", "POST"})
     */
    public function show(Evento $evento, Request $request, $id): Response
    {
        $listaRecados = $this->em->getRepository(EventoRecado::class)
            ->getQueryRecados($id);

        $solicitacao = $this->em->getRepository(EventoParticipante::class)
            ->queryPesquisaSolicitacao($this->getUser(), $evento);

        $participantes = $this->em->getRepository(EventoParticipante::class)
            ->contaParticipante($evento);

        $listaParticipantes = $this->em->getRepository(EventoParticipante::class)
            ->listaParticipantes($evento);

        $evento->setAcessos($evento->getAcessos() + 1);
        $this->em->flush();

        $recado = new EventoRecado();
        $form = $this->createForm(EventoRecadoType::class, $recado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $recado->setUser($this->getUser());
            $recado->setEvento($evento);
            $entityManager->persist($recado);
            $entityManager->flush();

            $this->addFlash('success', "Recado  envviado.");
            return $this->redirectToRoute('evento_index');
        }

        return $this->render('evento/show.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
            'solicitacao' => $solicitacao,
            'participantes' => $participantes,
            'listaParticipantes' => $listaParticipantes,
            'listaRecados' => $listaRecados,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evento_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evento $evento): Response
    {
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evento_index');
        }

        return $this->render('evento/edit.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evento_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evento $evento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evento->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evento_index');
    }

    /**
     * @Route("/solicitar/{id}", name="participar")
     */
    public function solicitarPerticipacao(Evento $evento)
    {
        $eventoParticipante = new EventoParticipante();
        $eventoParticipante->setParticipante($this->getUser());
        $eventoParticipante->setEvento($evento);
        $this->em->persist($eventoParticipante);
        $this->em->flush();

        return new JsonResponse(['success' => true, 'evento' =>['id' => $evento->getId()]]);
    }
}
