@extends('layouts.base', ['body' => ''])

@section('content')
    <div class="page">

        @include('layouts.partials._navigation')

        @include('layouts.partials._header')

        <div class="page-wrapper">
            @include('layouts.partials._content')
            @include('layouts.partials._footer')
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.theme = "{{ auth()->user()->theme }}";
    </script>
@endpush
