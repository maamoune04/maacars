<?php

namespace App\Controller;

use App\DTO\ReservationDTO;
use App\Service\ReservationService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class ReservationController extends AbstractController
{

    public function __construct(private readonly ReservationService $reservationService){}

    /**
     * @throws Exception
     */
    #[IsGranted('ROLE_USER')]
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
}
