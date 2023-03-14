<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    use HasFactory;

    public $table = 'course_user';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'course_id',
        'first',
        'mid',
        'final',
    ];
}
