@extends('layouts.app')

@section('title', 'Главная — Пространство')

@section('content')

<div class="container">

    <p class="eyebrow">Добро пожаловать на наш сайт</p>

    <h1>
        Идеи меняют мир.<br>
        <span class="blue-text">Начнём с малого.</span>
    </h1>

    <p class="description">
        Мы создаём пространство для новых идей,
        интересных проектов и современных технологий.
        Здесь вы можете узнать о нас и найти нужную информацию.
    </p>

    <a href="{{ route('about') }}" class="button">
        Узнать больше
    </a>

    <div class="cards">

        <div class="card">
            <p class="eyebrow">01 / Наша команда</p>
            <h2>Люди и идеи</h2>
            <p>
                За каждым интересным проектом стоят люди,
                их знания, опыт и стремление создавать новое.
            </p>
        </div>

        <div class="card">
            <p class="eyebrow">02 / Наша цель</p>
            <h2>Развитие и будущее</h2>
            <p>
                Мы изучаем современные технологии
                и применяем полученные знания на практике.
            </p>
        </div>

    </div>

</div>

@endsection