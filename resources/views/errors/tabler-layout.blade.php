@extends('layouts.base', ['body' => 'antialiased border-top-wide border-primary d-flex flex-column'])

@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-header">@yield('code', __('Oh no'))</div>
                <p class="empty-title">@yield('message')</p>

                <div class="empty-action">
                    <a href="{{ app('router')->has('home') ? route('home') : url('/') }}" class="btn btn-primary">
                        <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="11" y2="18" /><line x1="5" y1="12" x2="11" y2="6" /></svg>
                        {{ __('Go To Dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
