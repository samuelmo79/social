<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurtidaComentarioRepository")
 * @UniqueEntity(
 *     fields={"usuario", "comentario"},
 *     message="Essa postagem já foi curtida!"
 * )
 * @ORM\Table(name="curtida_comentario", uniqueConstraints={
 *     @ORM\UniqueConstraint(
 *          name="usuario_comentario",
 *          columns={"usuario_id","comentario_id"}
 *
 * )}
 * )
 */
class CurtidaComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="curtidaComentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostComentario", inversedBy="curtidaComentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comentario;

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

    public function getComentario(): ?PostComentario
    {
        return $this->comentario;
    }

    public function setComentario(?PostComentario $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }
}
