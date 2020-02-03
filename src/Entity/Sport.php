<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 */
class Sport
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Level", mappedBy="sport")
     */
    private $levels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FavoriteSport", mappedBy="sport")
     */
    private $favoriteSports;

    public function __construct()
    {
        $this->levels = new ArrayCollection();
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
     * @return Collection|Level[]
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    public function addLevel(Level $level): self
    {
        if (!$this->levels->contains($level)) {
            $this->levels[] = $level;
            $level->addSport($this);
        }

        return $this;
    }

    public function removeLevel(Level $level): self
    {
        if ($this->levels->contains($level)) {
            $this->levels->removeElement($level);
            $level->removeSport($this);
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
            $favoriteSport->setSport($this);
        }

        return $this;
    }

    public function removeFavoriteSport(FavoriteSport $favoriteSport): self
    {
        if ($this->favoriteSports->contains($favoriteSport)) {
            $this->favoriteSports->removeElement($favoriteSport);
            // set the owning side to null (unless already changed)
            if ($favoriteSport->getSport() === $this) {
                $favoriteSport->setSport(null);
            }
        }

        return $this;
    }
}
