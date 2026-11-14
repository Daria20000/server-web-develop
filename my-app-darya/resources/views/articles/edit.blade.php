
@extends('layouts.app')

@section('title', 'Редактирование новости')

@section('content')
<div class="container">

    <p class="eyebrow">Управление публикацией</p>

    <h1>Изменить <span class="blue-text">новость.</span></h1>

    <div class="card" style="max-width: 750px; margin-top: 30px;">

        @include('articles.form', [
            'article' => $article,
            'action' => route('articles.update', $article),
            'method' => 'PUT'
        ])

    </div>

</div>
@endsection
