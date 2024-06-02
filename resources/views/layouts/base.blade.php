<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- CSS files -->
    <link href="{{ asset('vendor/tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/demo.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/icons/tabler-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @include('layouts.partials._font-awesome')

    @include('layouts.partials._favicons')

    @stack('styles')
</head>
<body class="{{ $body }}">

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @include('sweetalert::alert')
    <!-- Tabler Core -->
    <script src="{{ asset('vendor/tabler/dist/js/tabler.min.js') }}"></script>
    @stack('scripts')
</body>
</html>

