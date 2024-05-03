<?php

namespace App\Enum;

enum ReservationStatusEnum
{
    case Cancelled;
    case Submitted;
    case Confirmed;
    case CarTaken;
    case Incident;
    case CarReturned;
}