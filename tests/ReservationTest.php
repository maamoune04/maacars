<?php

namespace App\Tests;

use App\DTO\ReservationDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReservationTest extends KernelTestCase
{
    public function testReservationDtoValid(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(0, $errors);
    }

    public function testReservationDTOStartDateBlank(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();
        $reservation->setStartDate('');

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(1, $errors);
    }

    public function testReservationDTOEndDateBlank(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();
        $reservation->setEndDate('');

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(2, $errors);
    }

    public function testReservationDTOStartDateInvalid(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();
        $reservation->setStartDate('2023-15-33');

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(2, $errors);
    }

    public function testReservationDTOEndDateInvalid(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();
        $reservation->setEndDate('2023-15-45');

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(1, $errors);
    }

    public function testReservationDTOEndDateBeforeStartDate(): void
    {
        self::bootKernel();

        $reservation = $this->_getDefaultReservation();
        $reservation->setStartDate('2023-05-15')
            ->setEndDate('2023-05-10')
            ;

        $errors = self::getContainer()->get('validator')->validate($reservation);

        $this->assertCount(1, $errors);
    }

    private function _getDefaultReservation(): ReservationDTO
    {
        $reservation = new ReservationDTO();
        $reservation->setCar(17)
            ->setStartDate('2023-05-10')
            ->setEndDate('2023-05-15')
            ;

        return $reservation;
    }
}
