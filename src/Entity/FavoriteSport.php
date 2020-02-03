<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteSportRepository")
 */
class FavoriteSport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="favoriteSports")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Sport", inversedBy="favoriteSports")
     */
    private $sport;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Level", inversedBy="favoriteSports")
     */
    private $level;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->sport = new ArrayCollection();
        $this->level = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

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
     * @return Collection|Level[]
     */
    public function getLevel(): Collection
    {
        return $this->level;
    }

    public function addLevel(Level $level): self
    {
        if (!$this->level->contains($level)) {
            $this->level[] = $level;
        }

        return $this;
    }

    public function removeLevel(Level $level): self
    {
        if ($this->level->contains($level)) {
            $this->level->removeElement($level);
        }

        return $this;
    }
}
