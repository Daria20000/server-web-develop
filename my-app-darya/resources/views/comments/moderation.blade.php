@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto;">

    <h1>Модерация комментариев</h1>

    <p class="description">
        Здесь отображаются комментарии, ожидающие проверки модератором.
    </p>

    @if (session('success'))
        <div class="card" style="margin: 20px 0; color: #16803c;">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($comments as $comment)

        <div class="card" style="margin-top: 20px; padding: 25px;">

            <h3>
                {{ $comment->user->name }}
            </h3>

            <p style="font-size: 13px; color: #888;">
                Статья: {{ $comment->article->title }}
            </p>

            <p style="margin-top: 15px;">
                {{ $comment->content }}
            </p>

            <p style="font-size: 13px; color: #888;">
                {{ $comment->created_at->format('d.m.Y в H:i') }}
            </p>

            <div style="display: flex; gap: 10px; margin-top: 20px;">

                <form
                    action="{{ route('comments.approve', $comment) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="button">
                        Принять
                    </button>
                </form>

                <form
                    action="{{ route('comments.reject', $comment) }}"
                    method="POST"
                    onsubmit="return confirm('Отклонить и удалить комментарий?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="button">
                        Отклонить
                    </button>
                </form>

            </div>

        </div>

    @empty

        <div class="card" style="margin-top: 25px;">
            <p>Нет комментариев, ожидающих модерации.</p>
        </div>

    @endforelse

</div>
@endsection