<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;

// Регистрация и авторизация
Route::post('/register', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);

// Получение списка статей
Route::get('/articles', [ArticleController::class, 'index']);

// Получение отдельной статьи
Route::get('/articles/{article}', [ArticleController::class, 'show']);

// Защищённые маршруты
Route::middleware('auth:sanctum')->group(function () {

    // Выход пользователя
    Route::post('/logout', [AuthController::class, 'logout']);

    // Создание, обновление и удаление статей
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

    // Информация о текущем пользователе
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
