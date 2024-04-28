<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        if (User::where('username', $data['username'])->exists()) {
            return response()->json([
                'message' => 'User already registered'
            ]);
        }

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->role = $data['role'];

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ]);
        }

        $user->delete();

        return response()->json([
            'message' => 'user deleted successfully'
        ]);
    }
}
