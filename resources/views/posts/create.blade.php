@extends('layouts.app')

@section('title', __('messages.create_blog'))

@section('page-title', __('messages.create_blog'))

@section('breadcrumbs', Breadcrumbs::render('posts.create'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Post</h3>
                    </div>
                    <div class="card-body">
                        <quill-editor toolbar="essential" theme="snow"></quill-editor>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/posts/create.js')
@endpush
