<?php

namespace App\Entity;

use App\Repository\RecipeBookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeBookRepository::class)]
class RecipeBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuisine = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;


    #[ORM\ManyToOne(inversedBy: 'recipeBooks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bookshelf $bookshelf = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCuisine(): ?string
    {
        return $this->cuisine;
    }

    public function setCuisine(?string $cuisine): self
    {
        $this->cuisine = $cuisine;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getBookshelf(): ?Bookshelf
    {
        return $this->bookshelf;
    }

    public function setBookshelf(?Bookshelf $bookshelf): self
    {
        $this->bookshelf = $bookshelf;

        return $this;
    }

    public function __toString() {
        return $this->title . " (Author: " . $this->author . ", Cuisine: " . $this->cuisine . ", year: " . $this->year . ")";
    }
}
