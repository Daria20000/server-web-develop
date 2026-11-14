
<form action="{{ $action }}" method="POST">

    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <div style="margin-bottom: 20px;">
        <label for="title">Заголовок новости</label>

        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $article?->title) }}"
            placeholder="Введите заголовок"
            style="display: block; width: 100%; padding: 14px; margin-top: 8px; border: 1px solid #d2d2d7; border-radius: 12px; box-sizing: border-box;"
        >

        @error('title')
            <p style="color: #d93025;">{{ $message }}</p>
        @enderror
    </div>

    <div style="margin-bottom: 20px;">
        <label for="description">Краткое описание</label>

        <textarea
            id="description"
            name="description"
            rows="3"
            placeholder="Введите краткое описание"
            style="display: block; width: 100%; padding: 14px; margin-top: 8px; border: 1px solid #d2d2d7; border-radius: 12px; box-sizing: border-box;"
        >{{ old('description', $article?->description) }}</textarea>

        @error('description')
            <p style="color: #d93025;">{{ $message }}</p>
        @enderror
    </div>

    <div style="margin-bottom: 20px;">
        <label for="content">Полный текст новости</label>

        <textarea
            id="content"
            name="content"
            rows="8"
            placeholder="Введите полный текст новости"
            style="display: block; width: 100%; padding: 14px; margin-top: 8px; border: 1px solid #d2d2d7; border-radius: 12px; box-sizing: border-box;"
        >{{ old('content', $article?->content) }}</textarea>

        @error('content')
            <p style="color: #d93025;">{{ $message }}</p>
        @enderror
    </div>

    <div style="margin-bottom: 25px;">
        <label for="image">Путь к изображению</label>

        <input
            type="text"
            id="image"
            name="image"
            value="{{ old('image', $article?->image) }}"
            placeholder="Например: images/news.jpg"
            style="display: block; width: 100%; padding: 14px; margin-top: 8px; border: 1px solid #d2d2d7; border-radius: 12px; box-sizing: border-box;"
        >

        @error('image')
            <p style="color: #d93025;">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="button">
        Сохранить
    </button>

    <a href="{{ route('articles.index') }}" class="button">
        Отмена
    </a>

</form>
