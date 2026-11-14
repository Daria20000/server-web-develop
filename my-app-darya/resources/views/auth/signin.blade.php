
@extends('layouts.app')

@section('title', 'Регистрация — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">Создание аккаунта</p>

    <h1>Присоединяйтесь к <span class="blue-text">нам.</span></h1>

    <p class="description">
        Заполните форму, чтобы отправить данные для регистрации.
    </p>

    <div class="card" style="max-width: 550px; margin-top: 35px;">

        <form action="{{ route('signin.registration') }}" method="POST">

            @csrf

            <div style="margin-bottom: 22px;">
                <label for="name">Имя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Введите ваше имя"
                    required
                    style="display: block; width: 100%; padding: 14px;
                    margin-top: 8px; border: 1px solid #d2d2d7;
                    border-radius: 12px; box-sizing: border-box;"
                >
            </div>

            <div style="margin-bottom: 22px;">
                <label for="email">Электронная почта</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="example@mail.com"
                    required
                    style="display: block; width: 100%; padding: 14px;
                    margin-top: 8px; border: 1px solid #d2d2d7;
                    border-radius: 12px; box-sizing: border-box;"
                >
            </div>

            <div style="margin-bottom: 25px;">
                <label for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Минимум 8 символов"
                    required
                    style="display: block; width: 100%; padding: 14px;
                    margin-top: 8px; border: 1px solid #d2d2d7;
                    border-radius: 12px; box-sizing: border-box;"
                >
            </div>

            <button type="submit" class="button">
                Зарегистрироваться
            </button>

        </form>

    </div>
</div>
@endsection
