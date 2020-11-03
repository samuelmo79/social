<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurtidaPostRepository")
 * @UniqueEntity(
 *     fields={"usuario", "postagem"},
 *     message="Essa postagem já foi curtida!"
 * )
 * @ORM\Table(name="curtida_post", uniqueConstraints={
 *     @ORM\UniqueConstraint(
 *          name="usuario_postagem",
 *          columns={"usuario_id","postagem_id"}
 *
 * )}
 * )
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
