<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostComentarioRepository")
 */
class PostComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="postComentarios")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="postComentarios")
     */
    private $post;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Esqueceu de comentar?")
     */
    private $comentario;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $dataComentario;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CurtidaComentario", mappedBy="comentario")
     */
    private $curtidaComentarios;

    public function __construct()
    {
        $this->curtidaComentarios = new ArrayCollection();
    }

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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getDataComentario(): ?DateTimeInterface
    {
        return $this->dataComentario;
    }

    public function setDataComentario(DateTimeInterface $dataComentario): self
    {
        $this->dataComentario = $dataComentario;

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
            $curtidaComentario->setComentario($this);
        }

        return $this;
    }

    public function removeCurtidaComentario(CurtidaComentario $curtidaComentario): self
    {
        if ($this->curtidaComentarios->contains($curtidaComentario)) {
            $this->curtidaComentarios->removeElement($curtidaComentario);
            // set the owning side to null (unless already changed)
            if ($curtidaComentario->getComentario() === $this) {
                $curtidaComentario->setComentario(null);
            }
        }

        return $this;
    }
}
