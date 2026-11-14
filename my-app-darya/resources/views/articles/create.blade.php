
@extends('layouts.app')

@section('title', 'Добавление новости')

@section('content')
<div class="container">

    <p class="eyebrow">Новая публикация</p>

    <h1>Создать <span class="blue-text">новость.</span></h1>

    <div class="card" style="max-width: 750px; margin-top: 30px;">

        @include('articles.form', [
            'article' => null,
            'action' => route('articles.store'),
            'method' => 'POST'
        ])

    </div>

</div>
@endsection
