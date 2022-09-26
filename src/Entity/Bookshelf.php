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

    #[ORM\Column(length: 255)]
    private ?string $RecipeBook = null;

    #[ORM\OneToMany(mappedBy: 'bookshelf', targetEntity: RecipeBook::class, orphanRemoval: true)]
    private Collection $recipeBooks;

    #[ORM\ManyToOne(inversedBy: 'bookshelf')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Library $library = null;

    public function __construct()
    {
        $this->recipeBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipeBook(): ?string
    {
        return $this->RecipeBook;
    }

    public function setRecipeBook(string $RecipeBook): self
    {
        $this->RecipeBook = $RecipeBook;

        return $this;
    }

    /**
     * @return Collection<int, RecipeBook>
     */
    public function getRecipeBooks(): Collection
    {
        return $this->recipeBooks;
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

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(?Library $library): self
    {
        $this->library = $library;

        return $this;
    }
}
