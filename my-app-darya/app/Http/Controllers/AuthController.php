<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Отображение формы регистрации
    public function registerForm()
    {
        return view('auth.register');
    }

    // Регистрация нового пользователя
    public function registration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Введите ваше имя.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Введите электронную почту.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.unique' => 'Пользователь с такой почтой уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        // Создание пользователя.
        // Пароль автоматически хешируется благодаря casts() в модели User.
        User::create($validated);

        return redirect()
            ->route('signin')
            ->with('success', 'Регистрация прошла успешно. Теперь войдите в аккаунт.');
    }

    // Отображение формы авторизации
    public function loginForm()
    {
        return view('auth.signin');
    }

    // Авторизация пользователя
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Введите электронную почту.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'password.required' => 'Введите пароль.',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Неверная электронная почта или пароль.',
                ])
                ->onlyInput('email');
        }

        // Защита сессии от session fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Создание токена Sanctum
        $token = $user->createToken('web-auth-token');

        // Сохраняем ID токена, чтобы удалить именно его при выходе
        $request->session()->put('auth_token_id', $token->accessToken->id);

        return redirect()
            ->route('home')
            ->with('success', 'Вы успешно вошли в аккаунт.');
    }

    // Выход пользователя
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $tokenId = $request->session()->get('auth_token_id');

            if ($tokenId) {
                $user->tokens()->where('id', $tokenId)->delete();
            }
        }

        Auth::logout();

        // Завершение старой сессии
        $request->session()->invalidate();

        // Обновление CSRF-токена
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Вы вышли из аккаунта.');
    }
}
