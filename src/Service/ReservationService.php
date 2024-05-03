<?php

namespace App\Service;

use App\DTO\ReservationDTO;
use App\Entity\Reservation;
use App\Enum\ReservationStatusEnum;
use App\Repository\CarRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

class ReservationService
{
    public function __construct(
        private readonly CarRepository $carRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security,
    ){}

    /**
     * @throws Exception we never know
     */
    public function addReservation(ReservationDTO $reservationDTO): Reservation
    {

        $reservation = new Reservation();

        $reservation->setStartDate(new DateTime($reservationDTO->getStartDate()))
                    ->setEndDate(new DateTime($reservationDTO->getEndDate()))
                    ->setCar($this->carRepository->find($reservationDTO->getCar()))
                    ->setUser($this->security->getUser()) // We can only make theme own reservation for the moment
                    ->setStatus(ReservationStatusEnum::Submitted)
                    ;

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

}