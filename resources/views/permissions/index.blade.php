@extends('layouts.app')

@section('title', __('messages.permissions'))

@section('page-title', __('messages.permissions'))

@section('breadcrumbs', Breadcrumbs::render('permissions.index'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.permission_list') }}</h3>
                    </div>

                    <livewire:permissions.permission-table/>
                </div>
            </div>
        </div>
    </div>
@endsection
