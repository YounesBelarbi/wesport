<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="participatingUserList")
     */
    private $eventParticipation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="eventOrganizer")
     */
    private $eventsOrganized;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassifiedAd", mappedBy="seller")
     */
    private $classifiedAds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContactList", mappedBy="creator")
     */
    private $contactLists;

    public function __construct()
    {
        $this->isActive = false;
        $this->eventParticipation = new ArrayCollection();
        $this->eventsOrganized = new ArrayCollection();
        $this->classifiedAds = new ArrayCollection();
        $this->contactLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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

    /**
    * @ORM\PrePersist
    */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventParticipation(): Collection
    {
        return $this->eventParticipation;
    }

    public function addEventParticipation(Event $eventParticipation): self
    {
        if (!$this->eventParticipation->contains($eventParticipation)) {
            $this->eventParticipation[] = $eventParticipation;
        }

        return $this;
    }

    public function removeEventParticipation(Event $eventParticipation): self
    {
        if ($this->eventParticipation->contains($eventParticipation)) {
            $this->eventParticipation->removeElement($eventParticipation);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventsOrganized(): Collection
    {
        return $this->eventsOrganized;
    }

    public function addEventsOrganized(Event $eventsOrganized): self
    {
        if (!$this->eventsOrganized->contains($eventsOrganized)) {
            $this->eventsOrganized[] = $eventsOrganized;
            $eventsOrganized->setEventOrganizer($this);
        }

        return $this;
    }

    public function removeEventsOrganized(Event $eventsOrganized): self
    {
        if ($this->eventsOrganized->contains($eventsOrganized)) {
            $this->eventsOrganized->removeElement($eventsOrganized);
            // set the owning side to null (unless already changed)
            if ($eventsOrganized->getEventOrganizer() === $this) {
                $eventsOrganized->setEventOrganizer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClassifiedAd[]
     */
    public function getClassifiedAds(): Collection
    {
        return $this->classifiedAds;
    }

    public function addClassifiedAd(ClassifiedAd $classifiedAd): self
    {
        if (!$this->classifiedAds->contains($classifiedAd)) {
            $this->classifiedAds[] = $classifiedAd;
            $classifiedAd->setSeller($this);
        }

        return $this;
    }

    public function removeClassifiedAd(ClassifiedAd $classifiedAd): self
    {
        if ($this->classifiedAds->contains($classifiedAd)) {
            $this->classifiedAds->removeElement($classifiedAd);
            // set the owning side to null (unless already changed)
            if ($classifiedAd->getSeller() === $this) {
                $classifiedAd->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactList[]
     */
    public function getContactLists(): Collection
    {
        return $this->contactLists;
    }

    public function addContactList(ContactList $contactList): self
    {
        if (!$this->contactLists->contains($contactList)) {
            $this->contactLists[] = $contactList;
            $contactList->setCreator($this);
        }

        return $this;
    }

    public function removeContactList(ContactList $contactList): self
    {
        if ($this->contactLists->contains($contactList)) {
            $this->contactLists->removeElement($contactList);
            // set the owning side to null (unless already changed)
            if ($contactList->getCreator() === $this) {
                $contactList->setCreator(null);
            }
        }

        return $this;
    }
}
