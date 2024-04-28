<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        $userData = array_merge($data, ['role' => $data['role'] ?? 'user']);

        if (User::where('username', $data['username'])->exists()) {
            return response()->json([
                'message' => 'User already registered'
            ]);
        }

        $user = User::create($userData);
        $user->password = Hash::make($userData['password']);
        $user->save();

        return response()->json([
            'message' => 'User registration successful',
            'data' => $user
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid username or password'
            ]);
        }

        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'role' => $user->role
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
