<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeguidorRepository")
 * @UniqueEntity(
 *     fields={"usuarioSeguidor", "usuarioSeguido"},
 *     message="Esse usuário ja é seguido por voce"
 * )
 * @ORM\Table(name="seguidor",uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="usuario_amigo",
 *          columns={"usuario_seguidor_id", "usuario_seguido_id"}
 * )}
 * )
 */
class Seguidor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="seguidors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioSeguidor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="seguindo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioSeguido;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioSeguidor(): ?User
    {
        return $this->usuarioSeguidor;
    }

    public function setUsuarioSeguidor(?User $usuarioSeguidor): self
    {
        $this->usuarioSeguidor = $usuarioSeguidor;

        return $this;
    }

    public function getUsuarioSeguido(): ?User
    {
        return $this->usuarioSeguido;
    }

    public function setUsuarioSeguido(?User $usuarioSeguido): self
    {
        $this->usuarioSeguido = $usuarioSeguido;

        return $this;
    }
}
