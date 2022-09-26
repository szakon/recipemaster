<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'library', targetEntity: Bookshelf::class, orphanRemoval: true)]
    private Collection $bookshelf;

    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    public function __construct()
    {
        $this->bookshelf = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Bookshelf>
     */
    public function getBookshelf(): Collection
    {
        return $this->bookshelf;
    }

    public function addBookshelf(Bookshelf $bookshelf): self
    {
        if (!$this->bookshelf->contains($bookshelf)) {
            $this->bookshelf->add($bookshelf);
            $bookshelf->setLibrary($this);
        }

        return $this;
    }

    public function removeBookshelf(Bookshelf $bookshelf): self
    {
        if ($this->bookshelf->removeElement($bookshelf)) {
            // set the owning side to null (unless already changed)
            if ($bookshelf->getLibrary() === $this) {
                $bookshelf->setLibrary(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
