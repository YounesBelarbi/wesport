<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LevelRepository")
 */
class Level
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Sport", inversedBy="levels")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FavoriteSport", mappedBy="leve")
     */
    private $favoriteSports;

    public function __construct()
    {
        $this->sport = new ArrayCollection();
        $this->favoriteSports = new ArrayCollection();
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

    /**
     * @return Collection|Sport[]
     */
    public function getSport(): Collection
    {
        return $this->sport;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sport->contains($sport)) {
            $this->sport[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sport->contains($sport)) {
            $this->sport->removeElement($sport);
        }

        return $this;
    }

    /**
     * @return Collection|FavoriteSport[]
     */
    public function getFavoriteSports(): Collection
    {
        return $this->favoriteSports;
    }

    public function addFavoriteSport(FavoriteSport $favoriteSport): self
    {
        if (!$this->favoriteSports->contains($favoriteSport)) {
            $this->favoriteSports[] = $favoriteSport;
            $favoriteSport->setLeve($this);
        }

        return $this;
    }

    public function removeFavoriteSport(FavoriteSport $favoriteSport): self
    {
        if ($this->favoriteSports->contains($favoriteSport)) {
            $this->favoriteSports->removeElement($favoriteSport);
            // set the owning side to null (unless already changed)
            if ($favoriteSport->getLeve() === $this) {
                $favoriteSport->setLeve(null);
            }
        }

        return $this;
    }
}
