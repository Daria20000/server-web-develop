
@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container">

    <p class="eyebrow">
        {{ $article->created_at->format('d.m.Y') }}
    </p>

    <h1>{{ $article->title }}</h1>

    <p class="description">
        {{ $article->description }}
    </p>

    <div class="card" style="max-width: 850px; margin-top: 30px;">

        @if ($article->image)
            <img
                src="{{ asset($article->image) }}"
                alt="{{ $article->title }}"
                style="width: 100%; border-radius: 16px;"
            >
        @endif

        <p style="font-size: 17px; line-height: 1.8; white-space: pre-line;">
            {{ $article->content }}
        </p>

        <div style="margin-top: 25px; display: flex; gap: 10px;">

            <a href="{{ route('articles.edit', $article) }}" class="button">
                Редактировать
            </a>

            <a href="{{ route('articles.index') }}" class="button">
                К новостям
            </a>

        </div>

    </div>

</div>
@endsection
