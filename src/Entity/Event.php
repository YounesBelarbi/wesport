<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Vich\Uploadable
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

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $image;


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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }
}
