<?php

declare(strict_types=1);

namespace App\Enum;

enum Role: string
{
    case Teacher = 'teacher';
    case Student = 'student';
    case Admin = 'admin';
}
