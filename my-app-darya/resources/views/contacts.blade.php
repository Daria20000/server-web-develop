@extends('layouts.app')

@section('title', 'Контакты — Пространство')

@section('content')

<div class="container">

    <p class="eyebrow">Будем рады знакомству</p>

    <h1>
        Всегда на <span class="blue-text">связи.</span>
    </h1>

    <p class="description">
        Здесь вы можете найти контактную информацию
        нашей команды и связаться с нужным специалистом.
    </p>

    <div class="contact-grid">

        @foreach ($contacts as $contact)

        <div class="contact-card">

            <div class="contact-icon">
                👤
            </div>

            <h3>{{ $contact['name'] }}</h3>

            <p class="contact-position">
                {{ $contact['position'] }}
            </p>

            <p class="contact-info">
                ✉ {{ $contact['email'] }}
            </p>

            <p class="contact-info">
                ☎ {{ $contact['phone'] }}
            </p>

        </div>

        @endforeach

    </div>

</div>

@endsection