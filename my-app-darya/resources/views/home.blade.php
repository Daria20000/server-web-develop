
@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="container">

    <p class="eyebrow">Новости и публикации</p>

    <h1>Мир <span class="blue-text">идей.</span></h1>

    <p class="description">
        Подборка интересных статей и материалов.
        Выберите публикацию, чтобы ознакомиться с ней подробнее.
    </p>

    <div class="cards">

        @foreach ($articles as $id => $article)

            <div class="card">

                <a href="{{ route('galery', $id) }}">
                    <img
                        src="{{ asset($article['preview_image']) }}"
                        alt="{{ $article['name'] }}"
                        style="width: 100%; border-radius: 16px;"
                    >
                </a>

                <p class="eyebrow">
                    {{ $article['date'] }}
                </p>

                <h2>{{ $article['name'] }}</h2>

                <p>
                    {{ $article['shortDesc'] ?? 'Подробнее о публикации.' }}
                </p>

                <a href="{{ route('galery', $id) }}" class="button">
                    Читать далее
                </a>

            </div>

        @endforeach

    </div>

</div>
@endsection
