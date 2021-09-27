<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     * @Assert\NotBlank(message="Please enter an event title")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     * @Assert\NotBlank(message="Please enter an event description")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $resume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $participant;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     * @Assert\NotBlank(message="Please choose a date")
     */
    private $startAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="events")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="event")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     * @Assert\NotBlank(message="Please enter an event category")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="event")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="createdEvent")
     * @Groups({"search_index", "event_list", "event_show", "event_add", "event_update", "event_delete"})
     */
    private $creator;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->event = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->startAt = new DateTimeImmutable('tomorrow');
        $this->status = 'en cours';
    }

    public function __toString()
    {
        return $this->id . ' ' . $this->title;
    }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getParticipant(): ?int
    {
        return $this->participant;
    }

    public function setParticipant(?int $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addEvent($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeEvent($this);
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
