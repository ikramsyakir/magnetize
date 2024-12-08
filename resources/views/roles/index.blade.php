@extends('layouts.app')

@section('title', 'Roles')

@section('breadcrumbs', Breadcrumbs::render('roles'))

@section('button')
    @can('create-role')
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Add New</a>
    @endcan
    <a href="#" class="btn btn-light" data-toggle="collapse" data-target="#filter">Filter</a>
@endsection

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles</h3>
                    </div>

                    <livewire:roles.role-table />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.delete-item')
@endpush
