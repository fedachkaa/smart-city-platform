<?php

namespace App\Enums;

enum UserRequestStatus: string
{
    case New = 'New';
    case InProgress = 'In Progress';
    case Resolved = 'Resolved';
}