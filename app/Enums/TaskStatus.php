<?php

namespace App\Enums;

enum TaskStatus: string
{
    case COMPLETED = 'completed';
    case PENDING = 'pending';
    case IN_PROGRESS = 'in-progress';
}