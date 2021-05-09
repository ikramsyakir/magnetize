@extends('layouts.app')

@section('title', 'Users')

@section('breadcrumbs', Breadcrumbs::render('users'))

@section('button')
    @can('create-user')
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
    @endcan
    <a href="#" class="btn btn-light" data-toggle="collapse" data-target="#filter">Filter</a>
@endsection

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            @include('users.index-filter')

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                            <tr>
                                <th>@sortablelink('name', 'Name')</th>
                                <th>@sortablelink('email', 'Email')</th>
                                <th>@sortablelink('username', 'Username')</th>
                                <th class="text-center">@sortablelink('email_verified_at', 'Status')</th>
                                <th>Roles</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                  style="background-image: url({{ $item->avatar ? asset($item->avatar) : Avatar::create($item->name)->toBase64() }})"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $item->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td class="text-center">
                                        @if($item->hasVerifiedEmail())
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-paper-plane text-warning"></i>
                                        @endif
                                    </td>
                                    <td>{{ $item->roles->isNotEmpty() ? $item->getRoleDisplayNames()->implode(', ') : 'No Role' }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-ghost-light align-text-top" href="#" role="button"
                                               data-toggle="dropdown" data-boundary="window">
                                                <i class="fas fa-ellipsis-h text-muted"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('user-profile')
                                                    <a class="dropdown-item"
                                                       href="{{ route('users.show', $item->id) }}">View</a>
                                                @endcan
                                                @can('update-user')
                                                    <a class="dropdown-item"
                                                       href="{{ route('users.edit', $item->id) }}">Edit</a>
                                                    <a class="dropdown-item" href="#"
                                                       onclick="confirmChangeStatus('{{ route('users.change-status', $item->id) }}');">Change
                                                        Status</a>
                                                @endcan
                                                @can('delete-user')
                                                    @if($item->id != auth()->user()->id)
                                                        <a class="dropdown-item" href="#"
                                                           onclick="confirmDelete('{{ route('users.destroy', $item->id) }}');">Delete</a>
                                                    @endif
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

                    @include('partials.pagination', ['items' => $users])

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.delete-item')
    @include('common.change-status')
@endpush
