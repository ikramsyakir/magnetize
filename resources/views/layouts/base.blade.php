<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS files -->
    <link href="{{ asset('vendor/tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/dist/css/demo.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/tabler/icons/tabler-icons.css') }}" rel="stylesheet"/>

    @include('layouts.partials._font-awesome')

    @include('layouts.partials._favicons')

    @stack('styles')
</head>
<body class="{{ $body }}">

    @yield('content')

    <!-- Scripts -->
    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'}
    </script>

    @include('sweetalert::alert')

    @stack('scripts')
</body>
</html>

