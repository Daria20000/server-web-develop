
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

    {{-- Основная информация о новости --}}
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

        <div style="margin-top: 25px; display: flex; gap: 10px; flex-wrap: wrap;">

            @if (auth()->user()?->isModerator())
                <a href="{{ route('articles.edit', $article) }}" class="button">
                    Редактировать
                </a>

                <form
                    action="{{ route('articles.destroy', $article) }}"
                    method="POST"
                    onsubmit="return confirm('Удалить эту новость?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="button">
                        Удалить
                    </button>
                </form>
            @endif

            <a href="{{ route('articles.index') }}" class="button">
                К новостям
            </a>

        </div>
    </div>

    {{-- Раздел комментариев --}}
    <div style="max-width: 850px; margin-top: 55px;">

        <h2>Комментарии</h2>

        <p class="description">
            Обсуждение новости и мнения читателей.
            Всего комментариев: {{ $article->comments->where('is_approved', true)->count() }}
        </p>

        {{-- Форма добавления комментария --}}
        @auth
            <div class="card" style="margin-top: 25px;">

                <h3>Оставить комментарий</h3>

                <form
                    action="{{ route('comments.store', $article) }}"
                    method="POST"
                >
                    @csrf

                    <textarea
                        name="content"
                        rows="4"
                        placeholder="Напишите ваш комментарий..."
                        style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #ddd; resize: vertical; font: inherit;"
                    >{{ old('content') }}</textarea>

                    @error('content')
                        <p style="color: #d93025; margin-top: 8px;">
                            {{ $message }}
                        </p>
                    @enderror

                    <button type="submit" class="button" style="margin-top: 15px;">
                        Отправить комментарий
                    </button>
                </form>

            </div>
        @else
            <p style="margin-top: 20px;">
                Чтобы оставить комментарий,
                <a href="{{ route('signin') }}">войдите в аккаунт</a>.
            </p>
        @endauth

        {{-- Список комментариев --}}
        <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 15px;">

            @forelse ($article->comments->where('is_approved', true) as $comment)

                <div class="card">

                    <div style="display: flex; justify-content: space-between; gap: 15px; flex-wrap: wrap;">

                        <div>
                            <strong>
                                {{ $comment->user->name }}
                            </strong>

                            <p style="font-size: 13px; color: #888; margin-top: 5px;">
                                {{ $comment->created_at->format('d.m.Y в H:i') }}
                            </p>
                        </div>

                        @if (auth()->user()?->isModerator())
                            <form
                                action="{{ route('comments.destroy', $comment) }}"
                                method="POST"
                                onsubmit="return confirm('Удалить комментарий?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="button">
                                    Удалить
                                </button>
                            </form>
                        @endif

                    </div>

                    <p style="font-size: 15px; line-height: 1.7; margin-top: 15px; white-space: pre-line;">
                        {{ $comment->content }}
                    </p>

                </div>

            @empty

                <div class="card" style="text-align: center; padding: 35px;">
                    <p style="color: #888;">
                        Пока нет комментариев. Будьте первым!
                    </p>
                </div>

            @endforelse

        </div>

    </div>

</div>
@endsection
