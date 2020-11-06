<?php

namespace App\Controller;

use App\Entity\AlbumFoto;
use App\Entity\Foto;
use App\Form\AlbumFotoType;
use App\Form\FotoType;
use App\Repository\AlbumFotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album/foto")
 */
class AlbumFotoController extends AbstractController
{
    /**
     * @Route("/", name="album_foto_index", methods={"GET"})
     */
    public function index(AlbumFotoRepository $albumFotoRepository): Response
    {
        return $this->render('album_foto/index.html.twig', [
            'album_fotos' => $albumFotoRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/new", name="album_foto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $albumFoto = new AlbumFoto();
        $form = $this->createForm(AlbumFotoType::class, $albumFoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $albumFoto->setUser($this->getUser());
            $entityManager->persist($albumFoto);
            $entityManager->flush();

            $this->addFlash('success', 'Álbum criado com sucesso!');
            return $this->redirectToRoute('album_foto_index');
        }

        return $this->render('album_foto/new.html.twig', [
            'album_foto' => $albumFoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_foto_show", methods={"GET","POST"})
     */
    public function show(AlbumFoto $albumFoto, Request $request): Response
    {
        $fotos = new Foto();
        $form = $this->createForm(FotoType::class, $fotos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $fotos->setAlbum($albumFoto);
            $entityManager->persist($fotos);
            $entityManager->flush();

            $this->addFlash('success', 'Álbum criado com sucesso!');
            return $this->redirectToRoute('album_foto_show', ['id' => $albumFoto->getId()]);
        }

        return $this->render('album_foto/show.html.twig', [
            'album_foto' => $albumFoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_foto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AlbumFoto $albumFoto): Response
    {
        $form = $this->createForm(AlbumFotoType::class, $albumFoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Álbum atualizado com sucesso!');
            return $this->redirectToRoute('album_foto_show', ['id' => $albumFoto->getId()]);
        }

        return $this->render('album_foto/edit.html.twig', [
            'album_foto' => $albumFoto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_foto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AlbumFoto $albumFoto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$albumFoto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($albumFoto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('album_foto_index');
    }
}
