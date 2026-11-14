<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Новости')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont,
                "SF Pro Display", "Helvetica Neue", Arial, sans-serif;
            color: #1d1d1f;
            background: #f5f5f7;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Навигация */

        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.07);
        }

        .navigation {
            max-width: 1100px;
            height: 60px;
            margin: auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -1px;
            color: #1d1d1f;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 34px;
        }

        .nav-links a {
            color: #424245;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #0071e3;
        }

        /* Основная часть */

        main {
            min-height: 75vh;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 90px 24px;
        }

        .eyebrow {
            color: #86868b;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 18px;
            letter-spacing: 0.5px;
        }

        h1 {
            font-size: clamp(42px, 7vw, 72px);
            line-height: 1.08;
            letter-spacing: -3px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        h2 {
            font-size: 32px;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 21px;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }

        .description {
            color: #6e6e73;
            font-size: 21px;
            max-width: 720px;
            line-height: 1.5;
        }

        .blue-text {
            color: #0071e3;
        }

        /* Кнопки */

        .button {
            display: inline-block;
            background: #0071e3;
            color: white;
            padding: 13px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            margin-top: 30px;
            transition: all 0.25s;
        }

        .button:hover {
            background: #0077ed;
            transform: translateY(-2px);
        }

        /* Карточки */

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-top: 55px;
        }

        .card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.025);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
        }

        .card p {
            color: #6e6e73;
            margin-top: 8px;
        }

        /* Контакты */

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 45px;
        }

        .contact-card {
            background: white;
            border-radius: 24px;
            padding: 28px;
            transition: transform 0.25s;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .contact-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: #f5f5f7;
            font-size: 22px;
            margin-bottom: 22px;
        }

        .contact-position {
            color: #86868b;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .contact-info {
            color: #0071e3;
            font-size: 14px;
            margin-top: 8px;
            overflow-wrap: anywhere;
        }

        /* Подвал */

        footer {
            background: #1d1d1f;
            color: white;
            padding: 35px 24px;
        }

        .footer-content {
            max-width: 1100px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-content p {
            color: #a1a1a6;
            font-size: 13px;
        }

        .footer-brand {
            font-size: 16px;
            font-weight: 600;
            color: white !important;
        }

        /* Адаптация под телефоны */

        @media (max-width: 700px) {
            .navigation {
                height: auto;
                min-height: 65px;
                flex-wrap: wrap;
                gap: 12px;
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .nav-links {
                gap: 18px;
            }

            .nav-links a {
                font-size: 12px;
            }

            .container {
                padding: 65px 20px;
            }

            h1 {
                letter-spacing: -2px;
            }

            .description {
                font-size: 18px;
            }

            .cards,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="navigation">

            <a href="{{ route('home') }}" class="logo">
                Главная
            </a>

            <nav class="nav-links">
                <a href="{{ route('about') }}">О нас</a>
                <a href="{{ route('contacts') }}">Контакты</a>
                <a href="{{ route('signin.create') }}">Регистрация</a>
                <a href="{{ route('articles.index') }}">Новости</a>
            </nav>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">

            <div>
                <p>Студентка: Юрченко Дарья Сергеевна</p>
                <p>Учебная группа: 257-321</p>
            </div>

            <p>© 2026. Все права защищены.</p>

        </div>
    </footer>

</body>

</html>