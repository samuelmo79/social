<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 * @Vich\Uploadable
 */
class Evento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"titulo"}, updatable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $descricao;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $dataEvento;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $acessos;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $rua;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complemento;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $bairro;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $cep;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="imagem_evento", fileNameProperty="imagem")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagem;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataCadastro;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $dataAtualizacao;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Este Campo não pode ser vazio!")
     */
    private $tipoEvento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventoParticipante", mappedBy="evento")
     */
    private $eventoParticipantes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventoRecado", mappedBy="evento")
     */
    private $eventoRecados;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventos")
     */
    private $user;

    public function __construct()
    {
        $this->eventoParticipantes = new ArrayCollection();
        $this->eventoRecados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getDataEvento(): ?\DateTimeInterface
    {
        return $this->dataEvento;
    }

    public function setDataEvento(?\DateTimeInterface $dataEvento): self
    {
        $this->dataEvento = $dataEvento;

        return $this;
    }

    public function getAcessos(): ?int
    {
        return $this->acessos;
    }

    public function setAcessos(?int $acessos): self
    {
        $this->acessos = $acessos;

        return $this;
    }

    public function getRua(): ?string
    {
        return $this->rua;
    }

    public function setRua(string $rua): self
    {
        $this->rua = $rua;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getComplemento(): ?string
    {
        return $this->complemento;
    }

    public function setComplemento(?string $complemento): self
    {
        $this->complemento = $complemento;

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(string $cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->dataAtualizacao = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(?string $imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeInterface
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(\DateTimeInterface $dataCadastro): self
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    public function getDataAtualizacao(): ?\DateTimeInterface
    {
        return $this->dataAtualizacao;
    }

    public function setDataAtualizacao(?\DateTimeInterface $dataAtualizacao): self
    {
        $this->dataAtualizacao = $dataAtualizacao;

        return $this;
    }

    public function getTipoEvento(): ?string
    {
        return $this->tipoEvento;
    }

    public function setTipoEvento(string $tipoEvento): self
    {
        $this->tipoEvento = $tipoEvento;

        return $this;
    }

    /**
     * @return Collection|EventoParticipante[]
     */
    public function getEventoParticipantes(): Collection
    {
        return $this->eventoParticipantes;
    }

    public function addEventoParticipante(EventoParticipante $eventoParticipante): self
    {
        if (!$this->eventoParticipantes->contains($eventoParticipante)) {
            $this->eventoParticipantes[] = $eventoParticipante;
            $eventoParticipante->setEvento($this);
        }

        return $this;
    }

    public function removeEventoParticipante(EventoParticipante $eventoParticipante): self
    {
        if ($this->eventoParticipantes->contains($eventoParticipante)) {
            $this->eventoParticipantes->removeElement($eventoParticipante);
            // set the owning side to null (unless already changed)
            if ($eventoParticipante->getEvento() === $this) {
                $eventoParticipante->setEvento(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventoRecado[]
     */
    public function getEventoRecados(): Collection
    {
        return $this->eventoRecados;
    }

    public function addEventoRecado(EventoRecado $eventoRecado): self
    {
        if (!$this->eventoRecados->contains($eventoRecado)) {
            $this->eventoRecados[] = $eventoRecado;
            $eventoRecado->setEvento($this);
        }

        return $this;
    }

    public function removeEventoRecado(EventoRecado $eventoRecado): self
    {
        if ($this->eventoRecados->contains($eventoRecado)) {
            $this->eventoRecados->removeElement($eventoRecado);
            // set the owning side to null (unless already changed)
            if ($eventoRecado->getEvento() === $this) {
                $eventoRecado->setEvento(null);
            }
        }

        return $this;
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
}
