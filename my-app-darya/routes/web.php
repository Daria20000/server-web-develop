<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {

    $contacts = [
        [
            'name' => 'Иван Иванов',
            'position' => 'Руководитель',
            'email' => 'ivan@example.com',
            'phone' => '+7 (900) 111-22-33'
        ],
        [
            'name' => 'Анна Петрова',
            'position' => 'Менеджер',
            'email' => 'anna@example.com',
            'phone' => '+7 (900) 444-55-66'
        ],
        [
            'name' => 'Дмитрий Сидоров',
            'position' => 'Разработчик',
            'email' => 'dmitry@example.com',
            'phone' => '+7 (900) 777-88-99'
        ]
    ];

    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');

Route::get('/', [MainController::class, 'index'])
    ->name('home');

Route::get('/galery/{id}', [MainController::class, 'galery'])
    ->name('galery');

Route::get('/signin', [AuthController::class, 'create'])
    ->name('signin.create');

Route::post('/signin', [AuthController::class, 'registration'])
    ->name('signin.registration');

Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');
