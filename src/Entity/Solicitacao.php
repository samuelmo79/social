<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SolicitacaoRepository")
 * @UniqueEntity(
 *     fields={"solicitante", "solicitado", "tipo"},
 *     message="Ja foi realizada solicitacao!"
 * )
 * @ORM\Table(name="solicitacao",uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="solicitante_solicitado_tipo",
 *          columns={"solicitante_id", "solicitado_id", "tipo"}
 * )}
 * )
 */
class Solicitacao
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="solicitacaos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $solicitante;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataSolicitacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="solicitados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $solicitado;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolicitante(): ?User
    {
        return $this->solicitante;
    }

    public function setSolicitante(?User $solicitante): self
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDataSolicitacao(): ?\DateTimeInterface
    {
        return $this->dataSolicitacao;
    }

    public function setDataSolicitacao(\DateTimeInterface $dataSolicitacao): self
    {
        $this->dataSolicitacao = $dataSolicitacao;

        return $this;
    }

    public function getSolicitado(): ?User
    {
        return $this->solicitado;
    }

    public function setSolicitado(?User $solicitado): self
    {
        $this->solicitado = $solicitado;

        return $this;
    }

}
