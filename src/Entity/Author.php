<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class,cascade: ["all"],orphanRemoval: true)]
    private Collection $nb_books;

    public function __construct()
    {
        $this->nb_books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getNbBooks(): Collection
    {
        return $this->nb_books;
    }

    public function addNbBook(Book $nbBook): static
    {
        if (!$this->nb_books->contains($nbBook)) {
            $this->nb_books->add($nbBook);
            $nbBook->setAuthor($this);
        }

        return $this;
    }

    public function removeNbBook(Book $nbBook): static
    {
        if ($this->nb_books->removeElement($nbBook)) {
            // set the owning side to null (unless already changed)
            if ($nbBook->getAuthor() === $this) {
                $nbBook->setAuthor(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return (string)$this->getId();
    }
}
