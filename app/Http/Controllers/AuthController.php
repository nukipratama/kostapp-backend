<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_CREATED);
    }
}
