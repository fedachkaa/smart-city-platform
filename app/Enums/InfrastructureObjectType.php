<?php

namespace App\Enums;

enum InfrastructureObjectType: string
{
    case Lighting   = 'Lighting';
    case TrashBin   = 'TrashBin';
    case Parking    = 'Parking';
    case Sensor     = 'Sensor';
    case Road       = 'Road';
}