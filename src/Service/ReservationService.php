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
                    ->setCar($this->carRepository->find($reservationDTO->getCars()))
                    ->setUser($this->security->getUser()) // We can only make theme own reservation for the moment
                    ->setStatus(ReservationStatusEnum::Submitted)
                    ;

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }


    public function isValideReservationDto(ReservationDTO $reservationDTO): array
    {
        $errors = [];

        if (empty($reservationDTO->getStartDate())) {
            $errors['startDate'] = 'Start date is required';
        }

        try {
            $startDate = new DateTime($reservationDTO->getStartDate());
        } catch (Exception $e) {
            $errors['startDate'] = 'Invalid start date, format must be Y-m-d';
            $startDate = null;
        }

        if (empty($reservationDTO->getEndDate())) {
            $errors['endDate'] = 'End date is required';
        }

        try {
            $endDate = new DateTime($reservationDTO->getEndDate());
        } catch (Exception $e) {
            $errors['endDate'] = 'Invalid end date, format must be Y-m-d';
            $endDate = null;
        }


        if ($startDate && $endDate && $startDate > $endDate) {
            $errors['endDate'] = 'End date must be greater than start date';
        }


        if (empty($reservationDTO->getCars())) {
            $errors['cars'] = 'Car is required';
        }


        if (!empty($reservationDTO->getCars()) && !$this->carRepository->find($reservationDTO->getCars())) {
            $errors['cars'] = 'Car not found';
        }

        //if we have no errors we can check if the car is available
        if (empty($errors) && $startDate && $endDate) {
            if (!$this->carRepository->isCarAvailable($this->carRepository->find($reservationDTO->getCars()), $startDate, $endDate)) {
                $errors['cars'] = 'Car not available for the given period';
            }
        }

        return $errors;
    }

}