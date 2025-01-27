@extends('layouts.app')

@section('title', __('messages.users'))

@section('page-title', __('messages.users'))

@section('breadcrumbs', Breadcrumbs::render('users.index'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.user_list') }}</h3>
                        <div class="card-actions">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-2"></i>
                                {{ __('messages.create_user') }}
                            </a>
                        </div>
                    </div>

                    <livewire:users.user-table />
                </div>
            </div>
        </div>
    </div>
@endsection
