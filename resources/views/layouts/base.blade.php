@use(App\Utilities\Localization)
@use(Illuminate\Support\Js)

<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.partials.favicons')

    @stack('styles')
</head>
<body class="{{ $body }}" data-bs-theme="{{ auth()->user() ? auth()->user()->theme : 'light' }}">

@yield('content')

<!-- Scripts -->
<script>
    window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    window.messages = {{ Js::from(Localization::get()) }};
</script>

<!-- Global route to JS -->
@routes

@include('sweetalert::alert')

<!-- toast --->
@include('partials.toasts')

@livewireScriptConfig

@stack('scripts')
</body>
</html>

