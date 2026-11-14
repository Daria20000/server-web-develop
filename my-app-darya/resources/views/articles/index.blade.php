
@extends('layouts.app')

@section('title', 'Новости — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">Новости и события</p>

    <h1>Последние <span class="blue-text">новости.</span></h1>

    <p class="description">
        Актуальные публикации и интересные материалы.
    </p>

    <div class="cards">
        @forelse ($articles as $article)

            <div class="card">

                @if ($article->image)
                    <img
                        src="{{ asset($article->image) }}"
                        alt="{{ $article->title }}"
                        style="width: 100%; border-radius: 16px;"
                    >
                @endif

                <p class="eyebrow">
                    {{ $article->created_at->format('d.m.Y') }}
                </p>

                <h2>{{ $article->title }}</h2>

                <p>{{ $article->description }}</p>

            </div>

        @empty

            <div class="card">
                <h2>Новостей пока нет</h2>
                <p>Загляните сюда немного позже.</p>
            </div>

        @endforelse
    </div>

</div>
@endsection
