<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('username', $request->username)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login success',
            'data' => [
                'token' => $token,
                'admin' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email
                ]
            ]
        ]);
    }

    public function logout() {
        try {
            Auth::user()->tokens()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Logout successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Logout error',
            ]);
        }
    }
}
