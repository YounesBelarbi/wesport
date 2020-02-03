<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $eventBody;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sportConcerned;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="date")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="eventParticipation")
     */
    private $participatingUserList;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventsOrganized")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eventOrganizer;

    public function __construct()
    {
        $this->participatingUserList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventBody(): ?string
    {
        return $this->eventBody;
    }

    public function setEventBody(string $eventBody): self
    {
        $this->eventBody = $eventBody;

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

    public function getSportConcerned(): ?string
    {
        return $this->sportConcerned;
    }

    public function setSportConcerned(string $sportConcerned): self
    {
        $this->sportConcerned = $sportConcerned;

        return $this;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipatingUserList(): Collection
    {
        return $this->participatingUserList;
    }

    public function addParticipatingUserList(User $participatingUserList): self
    {
        if (!$this->participatingUserList->contains($participatingUserList)) {
            $this->participatingUserList[] = $participatingUserList;
            $participatingUserList->addEventParticipation($this);
        }

        return $this;
    }

    public function removeParticipatingUserList(User $participatingUserList): self
    {
        if ($this->participatingUserList->contains($participatingUserList)) {
            $this->participatingUserList->removeElement($participatingUserList);
            $participatingUserList->removeEventParticipation($this);
        }

        return $this;
    }

    public function getEventOrganizer(): ?User
    {
        return $this->eventOrganizer;
    }

    public function setEventOrganizer(?User $eventOrganizer): self
    {
        $this->eventOrganizer = $eventOrganizer;

        return $this;
    }
}
