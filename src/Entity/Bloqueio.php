<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BloqueioRepository")
 */
class Bloqueio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bloqueiosEfetuados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioBloqueador;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bloqueiosRecebidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioBloqueado;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $dataBloqueio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioBloqueador(): ?User
    {
        return $this->usuarioBloqueador;
    }

    public function setUsuarioBloqueador(?User $usuarioBloqueador): self
    {
        $this->usuarioBloqueador = $usuarioBloqueador;

        return $this;
    }

    public function getUsuarioBloqueado(): ?User
    {
        return $this->usuarioBloqueado;
    }

    public function setUsuarioBloqueado(?User $usuarioBloqueado): self
    {
        $this->usuarioBloqueado = $usuarioBloqueado;

        return $this;
    }

    public function getDataBloqueio(): ?DateTimeInterface
    {
        return $this->dataBloqueio;
    }

    public function setDataBloqueio(DateTimeInterface $dataBloqueio): self
    {
        $this->dataBloqueio = $dataBloqueio;

        return $this;
    }
}
