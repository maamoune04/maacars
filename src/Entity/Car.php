<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

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
    #[Groups(['car:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['car:read', 'car:write'])]
    private ?string $brand = null;

    #[ORM\Column(length: 100)]
    #[Groups(['car:read', 'car:write'])]
    private ?string $model = null;

    #[ORM\Column(length: 15)]
    #[Groups(['car:read', 'car:write'])]
    private ?string $matricule = null;

    #[ORM\Column(length: 25)]
    #[Groups(['car:read', 'car:write'])]
    private ?string $color = null;

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
}