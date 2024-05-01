<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ReservationController extends AbstractController
{

    public function add(): JsonResponse
    {
        return $this->json(['message' => 'Todo: Implement the add method in ReservationController']);
    }
}
