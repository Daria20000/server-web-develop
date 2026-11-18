<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая статья</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f5f7; color: #1d1d1f; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px;">

        <h1 style="color: #0071e3;">
            Добавлена новая статья
        </h1>

        <p>Здравствуйте!</p>

        <p>
            В веб-приложении была опубликована новая статья.
            Просим ознакомиться с её содержанием.
        </p>

        <h2>{{ $article->title }}</h2>

        <p>
            <strong>Краткое описание:</strong>
        </p>

        <p>{{ $article->description }}</p>

        <hr>

        <h3>Содержание статьи:</h3>

        <p style="white-space: pre-line;">
            {{ $article->content }}
        </p>

        <hr>

        <p style="color: #86868b; font-size: 13px;">
            Это автоматическое уведомление от веб-приложения Laravel.
        </p>

    </div>

</body>
</html>
