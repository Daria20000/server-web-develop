@extends('layouts.app')

@section('title', 'О нас — Пространство')

@section('content')

<div class="container">

    <p class="eyebrow">Наша история и ценности</p>

    <h1>
        Немного <span class="blue-text">о нас.</span>
    </h1>

    <p class="description">
        Мы — команда, которая верит в силу знаний,
        технологий и постоянного развития.
    </p>

    <div class="cards">

        <div class="card">
            <p class="eyebrow">НАША МИССИЯ</p>
            <h2>Создавать новое</h2>
            <p>
                Наша задача — получать новые знания,
                находить интересные решения и превращать
                идеи в реальные проекты.
            </p>
        </div>

        <div class="card">
            <p class="eyebrow">НАШ ПОДХОД</p>
            <h2>Развиваться каждый день</h2>
            <p>
                Мы считаем, что качественный результат
                начинается с внимания к деталям,
                ответственности и желания учиться.
            </p>
        </div>

    </div>

    <div style="margin-top: 65px; max-width: 750px;">
        <h2>Почему мы это делаем?</h2>

        <p class="description" style="font-size: 17px;">
            Этот проект создан в рамках изучения основ
            серверной разработки. Мы используем Laravel
            и Blade, чтобы познакомиться с принципами
            создания современных веб-приложений.
        </p>
    </div>

</div>

@endsection