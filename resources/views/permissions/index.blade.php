@extends('layouts.app')

@section('title', 'Permissions')

@section('breadcrumbs', Breadcrumbs::render('permissions'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permissions</h3>
                    </div>

                    <livewire:permissions.permission-table />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.delete-item')
@endpush
