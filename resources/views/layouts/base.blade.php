<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.partials._favicons')

    @stack('styles')
</head>
<body class="{{ $body }}">

    @yield('content')

    <!-- Scripts -->
    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
        window.messages = {
            'oops': '{{ __('messages.oops') }}',
            'page_expired_try_again': '{{ __('messages.page_expired_try_again') }}',
        };
    </script>

    <!-- Global route to JS -->
    @routes

    @include('sweetalert::alert')

    @stack('scripts')
</body>
</html>

