<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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
