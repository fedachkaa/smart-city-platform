<?php

namespace App\Enums;

enum InfrastructureObjectStatus: string
{
    case Active = 'Active';
    case Maintenance = 'Maintenance';
    case Inactive = 'Inactive';
    case Error = 'Error';
}