<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserCollection;
use App\Models\User;

class AdminController extends Controller
{
    public function store(StoreRoleRequest $request): string|RoleResource
    {
        $validated = $request->validated();
        $user = auth()->user();
        if ($user->can('create', User::class)) {
            $user = User::where('email', $validated['email'])->first();
            $user->syncRoles([$validated['role']]);

            return new RoleResource($user);
        }

        return 'not authorized';
    }

    public function listStudents(): string|UserCollection
    {
        $user = auth()->user();
        if ($user->can('view', User::class)) {
            $students = User::role('student')->get();

            return new UserCollection($students);
        }

        return 'not authorized';
    }
}
