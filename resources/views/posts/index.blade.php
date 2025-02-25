@extends('layouts.app')

@section('title', __('messages.posts'))

@section('page-title', __('messages.posts'))

@section('breadcrumbs', Breadcrumbs::render('posts.index'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.post_list') }}</h3>
                        <div class="card-actions">
                            @can('add-posts')
                                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                    <i class="ti ti-plus me-2"></i>
                                    {{ __('messages.create_post') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        here
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
