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
    /** 
 * @OA\Post(
 * path="api/register",
 * summary="Sign up",
 * description="sign up by email, password, phone number",
 * operationId="authSignup",
 * tags={"Users"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password","phone"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="phone", type="string", example="+10 12345 678"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="The email has already been taken.")
 *        )
 *     ),
 * @OA\Response(
 *    response=201,
 *    description="User created response",
 *    @OA\JsonContent(
 *       @OA\Property(property="uuid", type="string", example="98b13a9a-61f8-4ea4-bc0e-260ab8f6d4e1"),
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="phone", type="string", example="+10 12345 678"),
 *        )
 *     )
 * )
 */
    public function store(StoreRegistrationRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $user = User::create($validated);
        $user = $user->assignRole('student');

        return new UserDetailResource($user);
    }

    /** Show user profile
 * @OA\Get(
 * path="api/user-profile",
 * summary="Show user profile",
 * description="show email, password, phone number",
 * tags={"Users"},
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="uuid", type="string", example="98b13a9a-61f8-4ea4-bc0e-260ab8f6d4e1"),
 *       @OA\Property(property="name", type="string", example="Sura Khalaf"),
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="phone", type="string", example="+10 12345 678"),
 *       @OA\Property(property="created_at", example="2020-01-01"),
 *       @OA\Property(property="updated_at", example="2020-01-01"),
 *        )
 *     ),
 * ),
 */
    public function show(): UserDetailResource
    {
        $user = auth()->user();

        return new UserDetailResource($user);
    }

    /**
 * Login User
 * @OA\Post(
 * path="api/login",
 * summary="Log in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"Users"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="email/password incorrect")
 *        )
 *     )
 * )
 */
    public function loginUser(StoreUserRequest $request): string
    {
        $validated = $request->validated();
        if (auth()->attempt($validated)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('school-token')->plainTextToken;
            $response = [
                'token' => $token,
            ];

            return 'Welcome' . ' ' . response(new RoleResource($user)) . ' ' . response($response);
        }

        return ''.response("email/password incorrect",422);
    }
}
