<?php

namespace App\Story;

use App\Factory\ReservationFactory;
use Zenstruck\Foundry\Story;

final class ReservationStory extends Story
{
    public function build(): void
    {
        ReservationFactory::createMany(9);
    }
}
