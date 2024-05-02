<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\ReservationStatusEnum;
use App\Repository\ReservationRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['reservation:collection:read']]),
        new Post(
            uriTemplate: '/reservations',
            controller: 'App\Controller\ReservationController::add',
            read: false,
            write: false,
            name: 'reservations_add'
        ),
        new Get(),
        new Put(),
        new Delete(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['reservation:collection:read', 'reservation:item:read']],
    denormalizationContext: ['groups' => ['reservation:write']],
)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    private ?Car $car = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    private ?int $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['reservation:collection:read', 'reservation:item:read', 'reservation:write'])]
    private ?string $note = null;

    #[ORM\Column]
    #[Groups(['reservation:collection:read', 'reservation:item:read'])]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reservation:collection:read', 'reservation:item:read'])]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    private ?DateTimeInterface $updatedAt = null;

    /**
     * set the createdAt date automatically when a new reservation is created
     * @return void
     */
    #[ORM\PrePersist]
    public function initCreatedAt(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    /**
     * update the updatedAt date automatically when a reservation is updated
     * @return void
     */
    #[ORM\PreUpdate]
    public function initUpdatedAt(): void
    {
        $this->setUpdatedAt(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    #[Groups(['reservation:collection:read', 'reservation:item:read'])]
    public function getStatusEnum(bool $name = true): ReservationStatusEnum|string
    {
        $enum = match ($this->status) {
            0 => ReservationStatusEnum::Cancel,
            1 => ReservationStatusEnum::Submitted,
            2 => ReservationStatusEnum::Confirmed,
            3 => ReservationStatusEnum::CarTaken,
            5 => ReservationStatusEnum::CarReturned,
            6 => ReservationStatusEnum::Incident,
        };

        return $name ? $enum->name : $enum;
    }

    public function setStatus(ReservationStatusEnum|int $status): static
    {
        //if the status is an enum, we convert it to an int
        if ($status instanceof ReservationStatusEnum) {
            $status = match ($status) {
                ReservationStatusEnum::Cancel => 0,
                ReservationStatusEnum::Submitted => 1,
                ReservationStatusEnum::Confirmed => 2,
                ReservationStatusEnum::CarTaken => 3,
                ReservationStatusEnum::CarReturned => 4,
                ReservationStatusEnum::Incident => 5,
            };
        }

        //status must be between 0 and 5
        if ($status < 0 || $status > 5) {
            throw new InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
