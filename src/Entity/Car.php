<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['car:read']],
    denormalizationContext: ['groups' => ['car:write']],
)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['car:read', 'reservation:item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['car:read', 'car:write', 'reservation:item:read'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $brand = null;

    #[ORM\Column(length: 100)]
    #[Groups(['car:read', 'car:write', 'reservation:item:read'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $model = null;

    #[ORM\Column(length: 15)]
    #[Groups(['car:read', 'car:write', 'reservation:item:read'])]
    #[Assert\NotBlank]
    #[Assert\Length(min:4, max: 15)]
    private ?string $matricule = null;

    #[ORM\Column(length: 25)]
    #[Groups(['car:read', 'car:write', 'reservation:item:read'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 25)]
    private ?string $color = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'car')]
    #[Groups(['car:read', 'car:write'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setCar($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCar() === $this) {
                $reservation->setCar(null);
            }
        }

        return $this;
    }
}
