<?php

namespace App\Policies;

use App\Enum\Role;
use App\Models\CourseUser;
use App\Models\User;

class CourseUserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CourseUser $courseStudent): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CourseUser $course): bool
    {
        //update student mark
        //return $user->hasRole(Role::Teacher->value);
        return $user->id == $course->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CourseUser $courseStudent): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CourseUser $courseStudent): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CourseUser $courseStudent): bool
    {
        return true;
    }
}
