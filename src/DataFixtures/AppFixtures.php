<?php

namespace App\DataFixtures;

use App\Story\CarStory;
use App\Story\ReservationStory;
use App\Story\UserStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(){}

    public function load(ObjectManager $manager): void
    {
        UserStory::load();
        CarStory::load();
        ReservationStory::load();
    }
}
