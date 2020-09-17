<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoParticipanteRepository")
 */
class EventoParticipante
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventoParticipantes")
     */
    private $participante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evento", inversedBy="eventoParticipantes")
     */
    private $evento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipante(): ?User
    {
        return $this->participante;
    }

    public function setParticipante(?User $participante): self
    {
        $this->participante = $participante;

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
}
