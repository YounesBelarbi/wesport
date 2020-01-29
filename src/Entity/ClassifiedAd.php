<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassifiedAdRepository")
 */
class ClassifiedAd
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
    private $classifiedAdBody;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

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
    private $objectForSale;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassifiedAdBody(): ?string
    {
        return $this->classifiedAdBody;
    }

    public function setClassifiedAdBody(string $classifiedAdBody): self
    {
        $this->classifiedAdBody = $classifiedAdBody;

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

    public function getObjectForSale(): ?string
    {
        return $this->objectForSale;
    }

    public function setObjectForSale(string $objectForSale): self
    {
        $this->objectForSale = $objectForSale;

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
}
