<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UsersCredit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $payload = $request->validated();

        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => Hash::make($payload['password']),
        ]);
        $user->role()->create([
            'role_id' => $payload['role_id']
        ]);
        $user->credit()->create([
            'credit' => UsersCredit::getDefaultUserCredit($user->id)
        ]);

        $response = User::where('id', $user->id)->with(['role.detail', 'credit'])->first();
        $response->access_token  = $response->createToken('auth_token')->plainTextToken;
        $response->token_type = 'Bearer';

        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->validated();
        if (!auth()->attempt($payload)) {
            throw new UnauthorizedException('Invalid email and password combination.');
        }
        $user = User::where('email', $payload['email'])->firstOrFail();
        $user->access_token  = $user->createToken('auth_token')->plainTextToken;
        $user->token_type = 'Bearer';

        $response = $user;

        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }

    public function profile()
    {
        $response = auth()->user()->load(['role.detail', 'credit']);

        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }
}
