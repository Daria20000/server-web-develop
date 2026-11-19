<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Регистрация нового пользователя
    public function registration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);

        $token = $user->createToken('api-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Регистрация прошла успешно.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Авторизация пользователя
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Неверная электронная почта или пароль.',
            ], 401);
        }

        $token = $user->createToken('api-auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Вы успешно вошли в аккаунт.',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // Выход пользователя
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Вы вышли из аккаунта.',
        ], 200);
    }
}
