<?php

namespace App\Entity;

use App\Repository\CityRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"countries_list", "country_show", "cities_list", "city_show", "event_list", "event_update", "event_show","category_list", "category_show", "search_index","user_show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"countries_list", "country_show","cities_list", "city_show", "event_list", "event_update", "event_show","category_list", "category_show", "search_index","user_show"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"countries_list", "country_show","cities_list", "city_show", "event_list", "event_update","event_show","category_list", "category_show", "search_index","user_show"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Groups({"cities_list", "city_show", "event_list"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * @Groups({"cities_list", "city_show", "event_list"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="city")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="cities")
     * @Groups({"city_show", "event_list", "event_update", "event_show","category_list", "category_show","user_show"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $countryCode;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();

    }

    public function __toString()
    {
        return $this->id . ' ' . $this->name;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setCity($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCity() === $this) {
                $event->setCity(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
