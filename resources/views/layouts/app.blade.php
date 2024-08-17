@extends('layouts.base', ['body' => ''])

@section('content')
    <div class="page">

        @include('layouts.partials.navigation')

        @include('layouts.partials.header')

        <div class="page-wrapper">
            @include('layouts.partials.content')
            @include('layouts.partials.footer')
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.theme = "{{ auth()->user()->theme }}";
    </script>
@endpush
