<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Bookshelf::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $bookshelf;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $about = null;

    public function __construct()
    {
        $this->bookshelf = new ArrayCollection();
    }

    public function getBookshelf(): Collection
    {
        return $this->bookshelf;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addBookshelf(Bookshelf $bookshelf): self
    {
        if (!$this->bookshelf->contains($bookshelf)) {
            $this->bookshlef->add($bookshelf);
            $bookshelf->setBookshelf($this);
        }

        return $this;
    }

    public function removeBookshelf(Bookshelf $bookshelf): self
    {
        if ($this->bookshelf->removeElement($bookshelf)) {
            // set the owning side to null (unless already changed)
            if ($bookshelf->getMember() === $this) {
                $bookshelf->setMember(null);
            }
        }

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }
}
