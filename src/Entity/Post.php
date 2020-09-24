<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @Vich\Uploadable
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $conteudo;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $privacidade;

    /**
     * @Vich\UploadableField(mapping="imagem_post", fileNameProperty="imagem")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */
    private $autor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostComentario", mappedBy="post")
     */
    private $postComentarios;

    public function __construct()
    {
        $this->postComentarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConteudo(): ?string
    {
        return $this->conteudo;
    }

    public function setConteudo(?string $conteudo): self
    {
        $this->conteudo = $conteudo;

        return $this;
    }

    public function getPrivacidade(): ?string
    {
        return $this->privacidade;
    }

    public function setPrivacidade(string $privacidade): self
    {
        $this->privacidade = $privacidade;

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
     * @throws \Exception
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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

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

    public function getAutor(): ?User
    {
        return $this->autor;
    }

    public function setAutor(?User $autor): self
    {
        $this->autor = $autor;

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
            $postComentario->setPost($this);
        }

        return $this;
    }

    public function removePostComentario(PostComentario $postComentario): self
    {
        if ($this->postComentarios->contains($postComentario)) {
            $this->postComentarios->removeElement($postComentario);
            // set the owning side to null (unless already changed)
            if ($postComentario->getPost() === $this) {
                $postComentario->setPost(null);
            }
        }

        return $this;
    }
}
