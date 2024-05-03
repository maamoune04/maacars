<?php

namespace App\Controller;

use App\DTO\ReservationDTO;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\CarService;
use App\Service\ReservationService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class ReservationController extends AbstractController
{

    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly ReservationRepository $reservationRepository,
        private readonly ValidatorInterface $validator,
        private readonly CarService $carService,
    ){}

    /**
     * @throws Exception
     */
    public function add(Request $request, SerializerInterface $serializer): Reservation|JsonResponse
    {
        $reservationDto = $serializer->deserialize($request->getContent(), ReservationDTO::class, 'json');

        $errors = $this->validator->validate($reservationDto);

        // if we have no validation errors we can check if the car is available
        if (!count($errors))
        {
            $errors = $this->carService->isAvailable($reservationDto->getCar(), $reservationDto->getStartDate(), $reservationDto->getEndDate(), true);
        }

        if (count($errors))
        {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        return $this->reservationService->addReservation($reservationDto);
    }

    public function userReservations($id): JsonResponse
    {
        return $this->json($this->reservationRepository->findBy(['user' => $id]));
    }
}
