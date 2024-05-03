<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Enum\ReservationStatusEnum;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * Check if a car is available for a given period
     * @param Car|int $car
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    public function isCarAvailable(Car|int $car, string $startDate, string $endDate): bool
    {

        if ($car instanceof Car) {
            $car = $car->getId();
        }

        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(r.id)')
            ->join('c.reservations', 'r')
            ->where('r.startDate <= :endDate')
            ->andWhere('r.endDate >= :startDate')
            ->andWhere('c = :car')
            ->andWhere('r.status != :status')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('car', $car)
            ->setParameter('status', Reservation::getStatusByEnum(ReservationStatusEnum::Cancelled))
        ;

        return $qb->getQuery()->getSingleScalarResult() === 0;
    }
}
