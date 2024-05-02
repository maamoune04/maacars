<?php

namespace App\DTO;
class ReservationDTO
{
    private string $startDate;

    private string $endDate;

    private int $cars;

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

    public function getCars(): int
    {
        return $this->cars;
    }

    public function setCars(int $cars): self
    {
        $this->cars = $cars;
        return $this;
    }
}