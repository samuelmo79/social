<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurtidaPostRepository")
 */
class CurtidaPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="curtidaPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="curtidaPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postagem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPostagem(): ?Post
    {
        return $this->postagem;
    }

    public function setPostagem(?Post $postagem): self
    {
        $this->postagem = $postagem;

        return $this;
    }
}
