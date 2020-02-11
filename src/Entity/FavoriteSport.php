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
     * @ORM\Id @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favoriteSports")
     */
    private $user;

    /**
     * @ORM\Id @ORM\ManyToOne(targetEntity="App\Entity\Sport", inversedBy="favoriteSports")
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="favoriteSports")
     */
    private $level;


  

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

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

   
}
