<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostComentarioRepository")
 */
class PostComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postComentarios")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="postComentarios")
     */
    private $post;

    /**
     * @ORM\Column(type="text")
     */
    private $comentario;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataComentario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getDataComentario(): ?\DateTimeInterface
    {
        return $this->dataComentario;
    }

    public function setDataComentario(\DateTimeInterface $dataComentario): self
    {
        $this->dataComentario = $dataComentario;

        return $this;
    }
}
