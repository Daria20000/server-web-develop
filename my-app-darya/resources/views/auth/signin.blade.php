
@extends('layouts.app')

@section('title', 'Авторизация — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">Добро пожаловать</p>

    <h1>С возвращением <span class="blue-text">.</span></h1>

    <p class="description">
        Войдите в свой аккаунт, чтобы продолжить работу.
    </p>

    <div class="card" style="max-width: 550px; margin-top: 35px;">

        @if (session('success'))
            <div style="padding:14px;background:#e8f5e9;color:#287d3c;border-radius:12px;margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('signin.login') }}" method="POST">
            @csrf

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

            <div style="margin-bottom: 25px;">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password"
                    placeholder="Введите пароль" required
                    style="display:block;width:100%;padding:14px;margin-top:8px;border:1px solid #d2d2d7;border-radius:12px;box-sizing:border-box;">
                @error('password')
                    <p style="color:#d93025;font-size:13px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="button">
                Войти
            </button>
        </form>

        <p style="margin-top:25px;color:#86868b;font-size:14px;">
            Ещё нет аккаунта?
            <a href="{{ route('register') }}">Зарегистрироваться</a>
        </p>

    </div>
</div>
@endsection
