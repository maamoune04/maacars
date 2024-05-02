<?php

namespace App\Controller;

use App\DTO\ReservationDTO;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class ReservationController extends AbstractController
{

    public function __construct(private readonly ReservationService $reservationService,private readonly ReservationRepository $reservationRepository){}

    /**
     * @throws Exception
     */
    public function add(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $reservationDto = $serializer->deserialize($request->getContent(), ReservationDTO::class, 'json');

        $errors = $this->reservationService->isValideReservationDto($reservationDto);
        if (count($errors))
        {
            return $this->json([
                'message' => 'Invalid data',
                'errors' => $errors,
            ], Response::HTTP_BAD_REQUEST);
        }

        $reservation = $this->reservationService->addReservation($reservationDto);

        return $this->json($reservation, Response::HTTP_CREATED);
    }

    public function userReservations($id): JsonResponse
    {
        return $this->json($this->reservationRepository->findBy(['user' => $id]));
    }
}
