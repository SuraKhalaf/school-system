<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreRegistrationRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $user = User::create($validated);
        $user = $user->assignRole('student');

        return new UserDetailResource($user);
    }

    public function show(): UserDetailResource
    {
        $user = auth()->user();

        return new UserDetailResource($user);
    }

    public function loginUser(StoreUserRequest $request): string
    {
        $validated = $request->validated();
        if (auth()->attempt($validated)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('school-token')->plainTextToken;
            $response = [
                'token' => $token,
            ];

            return 'Welcome' . ' ' . response(new RoleResource($user), 201) . ' ' . response($response, 201);
        }

        return 'email/password incorrect';
    }
}
