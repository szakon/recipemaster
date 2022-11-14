<?php

namespace App\Entity;

use App\Repository\BookshelfRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookshelfRepository::class)]
class Bookshelf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(nullable: false)]
    private ?string $Shelf = null;

    #[ORM\OneToMany(mappedBy: 'bookshelf', targetEntity: RecipeBook::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $recipeBooks;

    #[ORM\ManyToOne(inversedBy: 'bookshelf')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    public function __construct()
    {
        $this->recipeBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShelf(): ?string
    {
        return $this->Shelf;
    }

    public function setShelf(string $Shelf): self
    {
        $this->Shelf = $Shelf;

        return $this;
    }

    /**
     * @return Collection<int, RecipeBook>
     */
    public function getRecipeBooks(): Collection
    {
        return $this->recipeBooks;
    }

    public function getRecipeBooksString(): Collection
    {
        return $this->recipeBooks->__toString();
    }

    public function addRecipeBook(RecipeBook $recipeBook): self
    {
        if (!$this->recipeBooks->contains($recipeBook)) {
            $this->recipeBooks->add($recipeBook);
            $recipeBook->setBookshelf($this);
        }

        return $this;
    }

    public function removeRecipeBook(RecipeBook $recipeBook): self
    {
        if ($this->recipeBooks->removeElement($recipeBook)) {
            // set the owning side to null (unless already changed)
            if ($recipeBook->getBookshelf() === $this) {
                $recipeBook->setBookshelf(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function __toString() {
        return "This is the shelf: " . $this->Shelf;
    }
}
