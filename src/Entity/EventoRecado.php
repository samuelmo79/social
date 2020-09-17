<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRecadoRepository")
 */
class EventoRecado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventoRecados")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evento", inversedBy="eventoRecados")
     */
    private $evento;

    /**
     * @ORM\Column(type="text")
     */
    private $recado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataRecado;

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

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        $this->evento = $evento;

        return $this;
    }

    public function getRecado(): ?string
    {
        return $this->recado;
    }

    public function setRecado(string $recado): self
    {
        $this->recado = $recado;

        return $this;
    }

    public function getDataRecado(): ?\DateTimeInterface
    {
        return $this->dataRecado;
    }

    public function setDataRecado(\DateTimeInterface $dataRecado): self
    {
        $this->dataRecado = $dataRecado;

        return $this;
    }
}
