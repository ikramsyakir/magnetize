@extends('layouts.base', ['body' => 'antialiased'])

@section('content')
    <div class="wrapper">

        @include('layouts.partials._navigation')

        @include('layouts.partials._header')

        <div class="page-wrapper">
            @include('layouts.partials._content')
            @include('layouts.partials._footer')
        </div>

    </div>
@endsection
