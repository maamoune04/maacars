<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationDTO
{
    #[Assert\NotBlank]
    #[Assert\Date]
    private string $startDate;

    #[Assert\NotBlank]
    #[Assert\Date]
    #[Assert\GreaterThan(propertyPath: 'startDate')]
    private string $endDate;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private int $car;

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getCar(): int
    {
        return $this->car;
    }

    public function setCar(int $car): self
    {
        $this->car = $car;
        return $this;
    }
}