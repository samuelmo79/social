<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User implements UserInterface, Serializable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="avatar_perfil", fileNameProperty="avatar")
     *
     * @var File|null
     */
    private $imageFile;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="autor", cascade={"remove"})
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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Localizacao", inversedBy="user", cascade={"persist", "remove"})
     */
    private $localizacao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostComentario", mappedBy="user")
     */
    private $postComentarios;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tokenPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notificacao", mappedBy="user")
     */
    private $notificacaos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tokenResetPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Solicitacao", mappedBy="solicitante", orphanRemoval=true)
     */
    private $solicitacaos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Solicitacao", mappedBy="solicitado", orphanRemoval=true)
     */
    private $solicitados;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Amizade", mappedBy="usuario", orphanRemoval=true)
     */
    private $amizades;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CurtidaPost", mappedBy="usuario", orphanRemoval=true)
     */
    private $curtidaPosts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CurtidaComentario", mappedBy="usuario")
     */
    private $curtidaComentarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bloqueio", mappedBy="usuarioBloqueador", orphanRemoval=true)
     */
    private $bloqueiosEfetuados;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bloqueio", mappedBy="usuarioBloqueado", orphanRemoval=true)
     */
    private $bloqueiosRecebidos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AlbumFoto", mappedBy="user")
     */
    private $albumFotos;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->eventoParticipantes = new ArrayCollection();
        $this->eventoRecados = new ArrayCollection();
        $this->eventos = new ArrayCollection();
        $this->postComentarios = new ArrayCollection();
        $this->notificacaos = new ArrayCollection();
        $this->solicitacaos = new ArrayCollection();
        $this->amizades = new ArrayCollection();
        $this->curtidaPosts = new ArrayCollection();
        $this->curtidaComentarios = new ArrayCollection();
        $this->bloqueiosEfetuados = new ArrayCollection();
        $this->bloqueiosRecebidos = new ArrayCollection();
        $this->albumFotos = new ArrayCollection();
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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->dataAtualizacao = new DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

    public function getDataCadastro(): ?DateTimeInterface
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(DateTimeInterface $dataCadastro): self
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    public function getDataAtualizacao(): ?DateTimeInterface
    {
        return $this->dataAtualizacao;
    }

    public function setDataAtualizacao(?DateTimeInterface $dataAtualizacao): self
    {
        $this->dataAtualizacao = $dataAtualizacao;

        return $this;
    }

    public function getDataUltimoAcesso(): ?DateTimeInterface
    {
        return $this->dataUltimoAcesso;
    }

    public function setDataUltimoAcesso(?DateTimeInterface $dataUltimoAcesso): self
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

    public function getLocalizacao(): ?Localizacao
    {
        return $this->localizacao;
    }

    public function setLocalizacao(?Localizacao $localizacao): self
    {
        $this->localizacao = $localizacao;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->roles
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->roles
            ) = unserialize($serialized, ['allowed_class' => false]);
    }

    public function getTokenPassword(): ?string
    {
        return $this->tokenPassword;
    }

    public function setTokenPassword(?string $tokenPassword): self
    {
        $this->tokenPassword = $tokenPassword;

        return $this;
    }

    /**
     * @return Collection|PostComentario[]
     */
    public function getPostComentarios(): Collection
    {
        return $this->postComentarios;
    }

    public function addPostComentario(PostComentario $postComentario): self
    {
        if (!$this->postComentarios->contains($postComentario)) {
            $this->postComentarios[] = $postComentario;
            $postComentario->setUser($this);
        }

        return $this;
    }

    public function removePostComentario(PostComentario $postComentario): self
    {
        if ($this->postComentarios->contains($postComentario)) {
            $this->postComentarios->removeElement($postComentario);
            // set the owning side to null (unless already changed)
            if ($postComentario->getUser() === $this) {
                $postComentario->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notificacao[]
     */
    public function getNotificacaos(): Collection
    {
        return $this->notificacaos;
    }

    public function addNotificacao(Notificacao $notificacao): self
    {
        if (!$this->notificacaos->contains($notificacao)) {
            $this->notificacaos[] = $notificacao;
            $notificacao->setUser($this);
        }

        return $this;
    }

    public function removeNotificacao(Notificacao $notificacao): self
    {
        if ($this->notificacaos->contains($notificacao)) {
            $this->notificacaos->removeElement($notificacao);
            // set the owning side to null (unless already changed)
            if ($notificacao->getUser() === $this) {
                $notificacao->setUser(null);
            }
        }

        return $this;
    }

    public function getTokenResetPassword(): ?string
    {
        return $this->tokenResetPassword;
    }

    public function setTokenResetPassword(?string $tokenResetPassword): self
    {
        $this->tokenResetPassword = $tokenResetPassword;

        return $this;
    }

    /**
     * @return Collection|Solicitacao[]
     */
    public function getSolicitacaos(): Collection
    {
        return $this->solicitacaos;
    }

    /**
     * @return Collection|Solicitacao[]
     */
    public function getSolicitados(): Collection
    {
        return $this->solicitados;
    }

    public function addSolicitacao(Solicitacao $solicitacao): self
    {
        if (!$this->solicitacaos->contains($solicitacao)) {
            $this->solicitacaos[] = $solicitacao;
            $solicitacao->setSolicitante($this);
        }

        return $this;
    }

    public function removeSolicitacao(Solicitacao $solicitacao): self
    {
        if ($this->solicitacaos->contains($solicitacao)) {
            $this->solicitacaos->removeElement($solicitacao);
            // set the owning side to null (unless already changed)
            if ($solicitacao->getSolicitante() === $this) {
                $solicitacao->setSolicitante(null);
            }
        }

        return $this;
    }

    public function getTotalSolicitacoes()
    {
        $solicitados = $this->solicitados->toArray();
        $valor = 1;
        $solicitacoesPendentes = array_filter($solicitados, function ($solicitados) use ($valor) {
            return $solicitados->getStatus() == $valor;
        });

        return count($solicitacoesPendentes);
    }

    public function getTotalSolicitados()
    {
        $solicitante = $this->solicitacaos->toArray();
        $valor = 1;
        $solicitacoesEnviadas = array_filter($solicitante, function ($solicitante) use ($valor) {
            return $solicitante->getStatus() == $valor;
        });

        return count($solicitacoesEnviadas);
    }

    public function getTotalAmigos()
    {
        $totalAmigos = $this->amizades->toArray();

        return count($totalAmigos);
    }

    /**
     * @return Collection|Amizade[]
     */
    public function getAmizades(): Collection
    {
        return $this->amizades;
    }

    public function addAmizade(Amizade $amizade): self
    {
        if (!$this->amizades->contains($amizade)) {
            $this->amizades[] = $amizade;
            $amizade->setUsuario($this);
        }

        return $this;
    }

    public function removeAmizade(Amizade $amizade): self
    {
        if ($this->amizades->contains($amizade)) {
            $this->amizades->removeElement($amizade);
            // set the owning side to null (unless already changed)
            if ($amizade->getUsuario() === $this) {
                $amizade->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CurtidaPost[]
     */
    public function getCurtidaPosts(): Collection
    {
        return $this->curtidaPosts;
    }

    public function addCurtidaPost(CurtidaPost $curtidaPost): self
    {
        if (!$this->curtidaPosts->contains($curtidaPost)) {
            $this->curtidaPosts[] = $curtidaPost;
            $curtidaPost->setUsuario($this);
        }

        return $this;
    }

    public function removeCurtidaPost(CurtidaPost $curtidaPost): self
    {
        if ($this->curtidaPosts->contains($curtidaPost)) {
            $this->curtidaPosts->removeElement($curtidaPost);
            // set the owning side to null (unless already changed)
            if ($curtidaPost->getUsuario() === $this) {
                $curtidaPost->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CurtidaComentario[]
     */
    public function getCurtidaComentarios(): Collection
    {
        return $this->curtidaComentarios;
    }

    public function addCurtidaComentario(CurtidaComentario $curtidaComentario): self
    {
        if (!$this->curtidaComentarios->contains($curtidaComentario)) {
            $this->curtidaComentarios[] = $curtidaComentario;
            $curtidaComentario->setUsuario($this);
        }

        return $this;
    }

    public function removeCurtidaComentario(CurtidaComentario $curtidaComentario): self
    {
        if ($this->curtidaComentarios->contains($curtidaComentario)) {
            $this->curtidaComentarios->removeElement($curtidaComentario);
            // set the owning side to null (unless already changed)
            if ($curtidaComentario->getUsuario() === $this) {
                $curtidaComentario->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bloqueio[]
     */
    public function getBloqueiosEfetuados(): Collection
    {
        return $this->bloqueiosEfetuados;
    }

    public function addBloqueiosEfetuado(Bloqueio $bloqueiosEfetuado): self
    {
        if (!$this->bloqueiosEfetuados->contains($bloqueiosEfetuado)) {
            $this->bloqueiosEfetuados[] = $bloqueiosEfetuado;
            $bloqueiosEfetuado->setUsuarioBloqueador($this);
        }

        return $this;
    }

    public function removeBloqueiosEfetuado(Bloqueio $bloqueiosEfetuado): self
    {
        if ($this->bloqueiosEfetuados->contains($bloqueiosEfetuado)) {
            $this->bloqueiosEfetuados->removeElement($bloqueiosEfetuado);
            // set the owning side to null (unless already changed)
            if ($bloqueiosEfetuado->getUsuarioBloqueador() === $this) {
                $bloqueiosEfetuado->setUsuarioBloqueador(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bloqueio[]
     */
    public function getBloqueiosRecebidos(): Collection
    {
        return $this->bloqueiosRecebidos;
    }

    public function recebeuBloqueioDe(User $user)
    {
        $idUsuario = $user->getId();
        $listaTodosBloqueiosRecebidos = $this->getBloqueiosRecebidos()->toArray();

        $bloqueiosRecebidosPorUsuario = array_filter($listaTodosBloqueiosRecebidos,
            function ($listaTodosBloqueiosRecebidos) use ($idUsuario) {
                return $listaTodosBloqueiosRecebidos->getUsuarioBloqueador()->getId() == $idUsuario;
            });

        return $bloqueiosRecebidosPorUsuario != [];

    }

    public function efetuouBloqueio(User $user)
    {
        $idUsuario = $user->getId();
        $listaTodosBloqueioEfetuados = $this->getBloqueiosEfetuados()->toArray();

        $bloqueiosEfetuadosParaUsuario = array_filter($listaTodosBloqueioEfetuados,
            function ($listaTodosBloqueioEfetuados) use ($idUsuario) {
                return $listaTodosBloqueioEfetuados->getUsuarioBloqueado()->getId() == $idUsuario;
            });

        return $bloqueiosEfetuadosParaUsuario != [];
    }

    public function addBloqueiosRecebido(Bloqueio $bloqueiosRecebido): self
    {
        if (!$this->bloqueiosRecebidos->contains($bloqueiosRecebido)) {
            $this->bloqueiosRecebidos[] = $bloqueiosRecebido;
            $bloqueiosRecebido->setUsuarioBloqueado($this);
        }

        return $this;
    }

    public function removeBloqueiosRecebido(Bloqueio $bloqueiosRecebido): self
    {
        if ($this->bloqueiosRecebidos->contains($bloqueiosRecebido)) {
            $this->bloqueiosRecebidos->removeElement($bloqueiosRecebido);
            // set the owning side to null (unless already changed)
            if ($bloqueiosRecebido->getUsuarioBloqueado() === $this) {
                $bloqueiosRecebido->setUsuarioBloqueado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AlbumFoto[]
     */
    public function getAlbumFotos(): Collection
    {
        return $this->albumFotos;
    }

    public function addAlbumFoto(AlbumFoto $albumFoto): self
    {
        if (!$this->albumFotos->contains($albumFoto)) {
            $this->albumFotos[] = $albumFoto;
            $albumFoto->setUser($this);
        }

        return $this;
    }

    public function removeAlbumFoto(AlbumFoto $albumFoto): self
    {
        if ($this->albumFotos->contains($albumFoto)) {
            $this->albumFotos->removeElement($albumFoto);
            // set the owning side to null (unless already changed)
            if ($albumFoto->getUser() === $this) {
                $albumFoto->setUser(null);
            }
        }

        return $this;
    }

}
