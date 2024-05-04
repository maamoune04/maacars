<?php

namespace App\Tests;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CarTest extends KernelTestCase
{
    public function testCarValid(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(0, $errors);
    }

    public function testCarBrandBlank(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();
        $car->setBrand('');

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(1, $errors);
    }

    public function testCarModelBlank(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();
        $car->setModel('');

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(1, $errors);
    }

    public function testCarColorBlank(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();
        $car->setColor('');

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(1, $errors);
    }

    public function testCarMatriculeBlank(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();
        $car->setMatricule('   ');

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(1, $errors);
    }

    public function testCarMatriculeLength(): void
    {
        self::bootKernel();

        $car = $this->_getDefaultCar();
        $car->setMatricule('123');

        $errors = self::getContainer()->get('validator')->validate($car);

        $this->assertCount(1, $errors);
    }

    private function _getDefaultCar(): Car
    {
        $car = new Car();
        $car->setBrand('Audi')
            ->setModel('A4')
            ->setColor('Black')
            ->setMatricule('123-AF-45')
        ;

        return $car;
    }
}
