
@extends('layouts.app')

@section('title', $article['name'] . ' — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">
        {{ $article['date'] }}
    </p>

    <h1>{{ $article['name'] }}</h1>

    <p class="description">
        {{ $article['shortDesc'] ?? '' }}
    </p>

    <div style="margin-top: 35px;">

        <img
            src="{{ asset($article['full_image']) }}"
            alt="{{ $article['name'] }}"
            style="width: 100%; border-radius: 20px;"
        >

    </div>

    <div style="max-width: 850px; margin-top: 35px;">

        <p style="font-size: 18px; line-height: 1.8;">
            {{ $article['desc'] }}
        </p>

    </div>

    <div style="margin-top: 35px;">
        <a href="{{ route('home') }}" class="button">
            Вернуться к статьям
        </a>
    </div>

</div>
@endsection
