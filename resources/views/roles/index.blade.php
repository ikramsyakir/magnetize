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
            @include('roles.index-filter')

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                            <tr>
                                <th>@sortablelink('name', 'Name')</th>
                                <th>@sortablelink('display_name', 'Display Name')</th>
                                <th>@sortablelink('description', 'Description')</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-ghost-light align-text-top" href="#" role="button"
                                               data-toggle="dropdown" data-boundary="window">
                                                <i class="fas fa-ellipsis-h text-muted"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('update-role')
                                                    <a class="dropdown-item"
                                                       href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                @endcan
                                                @can('delete-role')
                                                    <a class="dropdown-item" href="#"
                                                       onclick="confirmDelete('{{ route('roles.destroy', $role->id) }}');">Delete</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No records</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @include('partials.pagination', ['items' => $roles])

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.delete-item')
@endpush
