<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <div>
            <ul class="menu">
                <li class="menu__item"><a href="{{ route('home') }}" class="menu__link link">Главная</a></li>
                <li class="menu__item"><a href="{{ route('articles') }}" class="menu__link link">Статьи</a></li>
                <li class="menu__item"><a href="{{ route('about') }}" class="menu__link link">О нас</a></li>
                <li class="menu__item"><a href="{{ route('contact') }}" class="menu__link link">Контакты</a></li>
                <li class="menu__item">
                    <form action="{{ route('logout') }}" method="post">@csrf
                    <button class="menu__link link">Выйти</button>
                    </form>
                </li>
            </ul>
        </div>
    </header>
    <main class="content">
        @yield('content')
    <main>
    <footer>
        <p>Акулов Кирилл 221-321</p>
    </footer>
</body>
</html>