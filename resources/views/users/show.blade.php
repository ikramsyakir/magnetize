@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumbs', Breadcrumbs::render('view_user', $user))

@can('update-user')
    @section('button')
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
    @endsection
@endcan

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-cover card-cover-blurred text-center" style="background-image: url({{ asset('images/photos/profile_wallpaper.jpg') }})">
                        <span class="avatar avatar-xl avatar-thumb avatar-rounded" style="background-image: url({{ $user->avatar ? asset($user->avatar) : Avatar::create($user->name)->toBase64() }})"></span>
                    </div>
                    <div class="card-body text-center">
                        <div class="card-title mb-1">{{ $user->name }}</div>
                        <div class="text-muted">{{ $user->roles->isNotEmpty() ? 'Role: ' . $user->getRoleDisplayNames()->implode(',') : 'No Role' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">User info</div>
                        <div class="mb-2">
                            <i class="fas fa-user-circle"></i>
                            Username: <strong>{{ $user->username }}</strong>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-envelope"></i>
                            Email: <strong>{{ $user->email }}</strong>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-clock"></i>
                            Created at: <strong>{{ $user->created_at->diffForHumans() }}</strong>
                        </div>
                        <div>
                            <i class="fas fa-history"></i>
                            Updated at: <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
