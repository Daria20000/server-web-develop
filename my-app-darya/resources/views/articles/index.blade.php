
@extends('layouts.app')

@section('title', 'Новости — Пространство')

@section('content')
<div class="container">

    <p class="eyebrow">Новости и события</p>

    <h1>Последние <span class="blue-text">новости.</span></h1>

    <p class="description">
        Управление публикациями и новостными материалами.
    </p>

    @can('create', App\Models\Article::class)
        <div style="margin: 30px 0;">
            <a href="{{ route('articles.create') }}" class="button">
                + Добавить новость
            </a>
        </div>
    @endcan

    @if (session('success'))
        <div class="card" style="margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="cards">
        @forelse ($articles as $article)

            <div class="card">

                <p class="eyebrow">
                    {{ $article->created_at->format('d.m.Y') }}
                </p>

                <h2>{{ $article->title }}</h2>

                <p>{{ $article->description }}</p>

                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px;">

                    <a href="{{ route('articles.show', $article) }}" class="button">
                        Открыть
                    </a>
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="button">
                            Изменить
                        </a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}"
                            method="POST"
                            onsubmit="return confirm('Удалить эту новость?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="button">
                                Удалить
                            </button>

                        </form>
                    @endcan

                </div>

            </div>

        @empty

            <div class="card">
                <h2>Новостей пока нет</h2>
                <p>Создайте первую публикацию.</p>
            </div>

        @endforelse
    </div>

    <div class="pagination">
        @if ($articles->onFirstPage())
            <span class="disabled"><span>Назад</span></span>
        @else
            <a href="{{ $articles->previousPageUrl() }}">Назад</a>
        @endif

        @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
            @if ($page == $articles->currentPage())
                <span class="active"><span>{{ $page }}</span></span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if ($articles->hasMorePages())
            <a href="{{ $articles->nextPageUrl() }}">Вперёд</a>
        @else
            <span class="disabled"><span>Вперёд</span></span>
        @endif
    </div>

    <div class="pagination-info">
        Страница {{ $articles->currentPage() }} из {{ $articles->lastPage() }}
        · Всего новостей: {{ $articles->total() }}
    </div>

</div>
@endsection
