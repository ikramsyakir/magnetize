@extends('layouts.base', ['body' => 'antialiased border-top-wide border-primary d-flex flex-column'])

@section('content')
    <div class="page page-center">
        @yield('main-content')
    </div>
@endsection
