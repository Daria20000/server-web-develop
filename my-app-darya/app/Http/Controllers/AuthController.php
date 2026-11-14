<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Отображение страницы регистрации
    public function create()
    {
        return view('auth.signin');
    }

    // Обработка данных формы регистрации
    public function registration(Request $request)
    {
        // Проверка введённых данных
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Поле имени обязательно для заполнения.',
            'email.required' => 'Поле электронной почты обязательно.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'password.required' => 'Поле пароля обязательно.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
        ]);

        // Если проверка не пройдена, возвращаем ошибки
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Получаем проверенные данные
        $data = $validator->validated();

        // Формируем JSON-ответ
        return response()->json([
            'success' => true,
            'message' => 'Данные успешно проверены.',
            'user' => [
                'name' => $data['name'],
                'email' => $data['email'],
            ]
        ], 200);
    }
}
