<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     */
    private $senhaPura;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DadosPessoais", inversedBy="user", cascade={"persist", "remove"})
     */
    private $dadosPessoais;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ativo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $acessos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataUltimoAcesso;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="autor")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventoParticipante", mappedBy="participante")
     */
    private $eventoParticipantes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventoRecado", mappedBy="user")
     */
    private $eventoRecados;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="user")
     */
    private $eventos;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->eventoParticipantes = new ArrayCollection();
        $this->eventoRecados = new ArrayCollection();
        $this->eventos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenhaPura()
    {
        return $this->senhaPura;
    }

    /**
     * @param mixed $senhaPura
     * @return User
     */
    public function setSenhaPura($senhaPura)
    {
        $this->senhaPura = $senhaPura;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDadosPessoais(): ?DadosPessoais
    {
        return $this->dadosPessoais;
    }

    public function setDadosPessoais(?DadosPessoais $dadosPessoais): self
    {
        $this->dadosPessoais = $dadosPessoais;

        return $this;
    }

    public function getAtivo(): ?bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): self
    {
        $this->ativo = $ativo;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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

    public function getDataUltimoAcesso(): ?\DateTimeInterface
    {
        return $this->dataUltimoAcesso;
    }

    public function setDataUltimoAcesso(?\DateTimeInterface $dataUltimoAcesso): self
    {
        $this->dataUltimoAcesso = $dataUltimoAcesso;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAutor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getAutor() === $this) {
                $post->setAutor(null);
            }
        }

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
            $eventoParticipante->setParticipante($this);
        }

        return $this;
    }

    public function removeEventoParticipante(EventoParticipante $eventoParticipante): self
    {
        if ($this->eventoParticipantes->contains($eventoParticipante)) {
            $this->eventoParticipantes->removeElement($eventoParticipante);
            // set the owning side to null (unless already changed)
            if ($eventoParticipante->getParticipante() === $this) {
                $eventoParticipante->setParticipante(null);
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
            $eventoRecado->setUser($this);
        }

        return $this;
    }

    public function removeEventoRecado(EventoRecado $eventoRecado): self
    {
        if ($this->eventoRecados->contains($eventoRecado)) {
            $this->eventoRecados->removeElement($eventoRecado);
            // set the owning side to null (unless already changed)
            if ($eventoRecado->getUser() === $this) {
                $eventoRecado->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos[] = $evento;
            $evento->setUser($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->contains($evento)) {
            $this->eventos->removeElement($evento);
            // set the owning side to null (unless already changed)
            if ($evento->getUser() === $this) {
                $evento->setUser(null);
            }
        }

        return $this;
    }
}