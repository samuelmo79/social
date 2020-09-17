<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DadosPessoaisRepository")
 */
class DadosPessoais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $sobrenome;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexo;

    /**
     * @ORM\Column(type="date")
     */
    private $dataNascimento;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="dadosPessoais", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getSobrenome(): ?string
    {
        return $this->sobrenome;
    }

    public function setSobrenome(string $sobrenome): self
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newDadosPessoais = null === $user ? null : $this;
        if ($user->getDadosPessoais() !== $newDadosPessoais) {
            $user->setDadosPessoais($newDadosPessoais);
        }

        return $this;
    }
}
