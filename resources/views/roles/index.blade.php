@extends('layouts.app')

@section('title', __('messages.roles'))

@section('page-title', __('messages.roles'))

@section('breadcrumbs', Breadcrumbs::render('roles.index'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.role_list') }}</h3>
                        <div class="card-actions">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-2"></i>
                                {{ __('messages.create_role') }}
                            </a>
                        </div>
                    </div>

                    <livewire:roles.role-table />
                </div>
            </div>
        </div>
    </div>
@endsection
