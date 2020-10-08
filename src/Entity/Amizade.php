<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmizadeRepository")
 */
class Amizade
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="amizades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Solicitacao")
     */
    private $solicitacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $amigo;

    public function __construct()
    {
        $this->solicitacao = new ArrayCollection();
    }

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

    /**
     * @return Collection|Solicitacao[]
     */
    public function getSolicitacao(): Collection
    {
        return $this->solicitacao;
    }

    public function addSolicitacao(Solicitacao $solicitacao): self
    {
        if (!$this->solicitacao->contains($solicitacao)) {
            $this->solicitacao[] = $solicitacao;
        }

        return $this;
    }

    public function removeSolicitacao(Solicitacao $solicitacao): self
    {
        if ($this->solicitacao->contains($solicitacao)) {
            $this->solicitacao->removeElement($solicitacao);
        }

        return $this;
    }

    public function getAmigo(): ?User
    {
        return $this->amigo;
    }

    public function setAmigo(?User $amigo): self
    {
        $this->amigo = $amigo;

        return $this;
    }
}
