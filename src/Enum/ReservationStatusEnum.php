<?php

namespace App\Enum;

enum ReservationStatusEnum
{
    case Cancel;
    case Submitted;
    case Confirmed;
    case CarTaken;
    case Incident;
    case CarReturned;
}