<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
