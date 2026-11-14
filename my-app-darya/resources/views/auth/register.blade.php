
@extends('layouts.app')

@section('title', 'Регистрация — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">Создание аккаунта</p>

    <h1>Присоединяйтесь к <span class="blue-text">нам.</span></h1>

    <p class="description">
        Создайте аккаунт, чтобы получить доступ ко всем возможностям приложения.
    </p>

    <div class="card" style="max-width: 550px; margin-top: 35px;">

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 22px;">
                <label for="name">Имя</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name') }}"
                    placeholder="Введите ваше имя" required
                    style="display:block;width:100%;padding:14px;margin-top:8px;border:1px solid #d2d2d7;border-radius:12px;box-sizing:border-box;">
                @error('name')
                    <p style="color:#d93025;font-size:13px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label for="email">Электронная почта</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="example@mail.com" required
                    style="display:block;width:100%;padding:14px;margin-top:8px;border:1px solid #d2d2d7;border-radius:12px;box-sizing:border-box;">
                @error('email')
                    <p style="color:#d93025;font-size:13px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password"
                    placeholder="Минимум 8 символов" required
                    style="display:block;width:100%;padding:14px;margin-top:8px;border:1px solid #d2d2d7;border-radius:12px;box-sizing:border-box;">
                @error('password')
                    <p style="color:#d93025;font-size:13px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label for="password_confirmation">Повторите пароль</label>
                <input type="password" id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Повторите пароль" required
                    style="display:block;width:100%;padding:14px;margin-top:8px;border:1px solid #d2d2d7;border-radius:12px;box-sizing:border-box;">
            </div>

            <button type="submit" class="button">
                Зарегистрироваться
            </button>
        </form>

        <p style="margin-top:25px;color:#86868b;font-size:14px;">
            Уже есть аккаунт?
            <a href="{{ route('signin') }}">Войти</a>
        </p>

    </div>
</div>
@endsection
