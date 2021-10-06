<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte avec cet E-mail")
 * @UniqueEntity(fields={"nickname"}, message="Il existe déjà un compte avec ce pseudo")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_list", "user_show"})
     * @Assert\NotBlank(message="Merci de remplir les champs requis")
     * @Groups({"event_list", "event_show", "event_update", "search_index", "user_add", "reset_password"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user_add"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $image;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="smallint", nullable=true)
=======
     * @ORM\Column(type="smallint",nullable=true)
>>>>>>> feature/add-forgot-password
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"event_list", "event_show", "event_update", "search_index","user_list","user_show", "user_add"})
     */
    private $language;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"user_list", "user_show","user_list","user_show"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"user_list", "user_show"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="users")
     * @Groups({"user_list", "user_show"})
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="creator", orphanRemoval=true) 
     * @Groups({"user_list", "user_show"})
     * 
     */
    private $createdEvent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user_list", "user_show"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_list", "user_show"})
     */
    private $gender;

    

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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->password = null;
    }

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->createdEvent = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->nickname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getCreatedEvent(): Collection
    {
        return $this->createdEvent;
    }

    public function addCreatedEvent(Event $createdEvent): self
    {
        if (!$this->createdEvent->contains($createdEvent)) {
            $this->createdEvent[] = $createdEvent;
            $createdEvent->setCreator($this);
        }

        return $this;
    }

    public function removeCreatedEvent(Event $createdEvent): self
    {
        if ($this->createdEvent->removeElement($createdEvent)) {
            // set the owning side to null (unless already changed)
            if ($createdEvent->getCreator() === $this) {
                $createdEvent->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of nickname
     */ 
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @return  self
     */ 
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}
