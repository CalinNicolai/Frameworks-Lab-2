<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page title passed through section -->
    <title>@yield('pageTitle','Default')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="style.css" rel="stylesheet">

    @stack('styles')
    <style>
        .navbar {
            background-color: #007bff; /* Цвет фона для Navbar */
            padding: 15px; /* Отступы */
        }

        .navbar-brand {
            color: #ffffff; /* Цвет текста для логотипа */
            font-size: 24px; /* Размер шрифта */
            text-decoration: none; /* Убираем подчеркивание */
        }

        .navbar-nav {
            list-style-type: none; /* Убираем маркеры у списка */
            padding: 0; /* Убираем отступы */
        }

        .nav-item {
            display: inline; /* Отображение в строку */
            margin-right: 20px; /* Отступы между элементами */
        }

        .nav-link {
            color: #ffffff; /* Цвет текста для ссылок */
            text-decoration: none; /* Убираем подчеркивание */
            font-size: 18px; /* Размер шрифта */
        }

        .nav-link:hover {
            color: #d3d3d3; /* Цвет текста при наведении */
        }

        .navbar-toggler {
            display: none; /* Скрываем кнопку для мобильных устройств */
        }

        /* Медиазапрос для мобильных устройств */
        @media (max-width: 768px) {
            .navbar-nav {
                display: none; /* Скрываем навигацию по умолчанию */
                flex-direction: column; /* Вертикальное расположение элементов */
            }

            .navbar-toggler {
                display: inline-block; /* Показываем кнопку для мобильных устройств */
                background-color: transparent; /* Прозрачный фон */
                border: none; /* Убираем границу */
                color: #ffffff; /* Цвет текста кнопки */
            }

            .navbar-toggler:focus {
                outline: none; /* Убираем обводку при фокусе */
            }

            .navbar-toggler.active + .navbar-nav {
                display: flex; /* Показываем навигацию при нажатии на кнопку */
            }
        }

    </style>

    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('scripts')
</head>
