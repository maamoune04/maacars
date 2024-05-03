<?php

namespace App\Service;

use App\Repository\CarRepository;
use DateTimeInterface;

class CarService
{
    public function __construct(private readonly CarRepository $carRepository){}

    public function isAvailable(int $carId, string|DateTimeInterface $startDate, string|DateTimeInterface $endDate, bool $errorDetails = false): bool|array
    {
        if ($startDate instanceof DateTimeInterface) {
            $startDate = $startDate->format('Y-m-d');
        }

        if ($endDate instanceof DateTimeInterface) {
            $endDate = $endDate->format('Y-m-d');
        }

        $errors = [];

        if ($errorDetails) {
            $car = $this->carRepository->find($carId);
            if (!$car)
            {
                $errors['type'] = 'business.logic.violation';
                $errors['violations'] = [
                    'propertyPath' => 'car',
                    'title' => 'Car not found',
                    'parameters' => ['{{ carId }}' => $carId],
                    'type' => 'entity.not_found',
                    'template' => 'The car with id {{ carId }} was not found.',
                ];

                return $errors;
            }
        }

        $isAvailable = $this->carRepository->isCarAvailable($carId, $startDate, $endDate);

        if ($errorDetails)
        {
            if (!$isAvailable)
            {
                $errors['type'] = 'business.logic.violation';
                $errors['violations'] = [
                    'propertyPath' => 'car',
                    'title' => 'Car not available for the given period',
                    'parameters' => ['{{ carId }}' => $carId, '{{ startDate }}' => $startDate, '{{ endDate }}' => $endDate],
                    'type' => 'entity.not_available',
                    'template' => 'The car with id {{ carId }} is not available for the period from {{ startDate }} to {{ endDate }}.',
                ];

                return $errors;
            }
        }

        return $errorDetails ? $errors : $isAvailable;
    }

}