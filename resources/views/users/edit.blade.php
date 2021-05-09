@extends('layouts.app')

@section('title', 'Edit User')

@section('breadcrumbs', Breadcrumbs::render('edit_user', $user))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 ">
                                    <label class="form-label required">Name</label>

                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ $user->name }}" placeholder="John Doe" required
                                           autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 ">
                                    <label class="form-label required">Username</label>

                                    <input id="username" type="text"
                                           class="form-control @error('username') is-invalid @enderror" name="username"
                                           value="{{ $user->username }}" placeholder="johndoe" required
                                           autocomplete="username">

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 ">
                                    <label class="form-label required">Email address</label>

                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ $user->email }}" placeholder="johndoe@email.com" required
                                           autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @can('read-user')
                                    <div class="form-group mb-3">
                                        <div class="form-label required">Roles</div>
                                        <div>
                                            @foreach($roles as $role)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input @error('roles') is-invalid @enderror"
                                                           type="checkbox" name="roles[]"
                                                           value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                                    <span class="form-check-label">{{ $role->display_name }}</span>
                                                </label>
                                            @endforeach

                                            @error('roles')
                                            <div class="invalid-feedback d-block">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endcan
                                <div class="form-footer text-end">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-link">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-0 mt-0 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3">
                        <div class="card">
                            <div class="card-body p-4 text-center">
                                <span class="avatar avatar-xl mb-3"
                                      style="background-image: url({{ $user->avatar ? asset($user->avatar) : Avatar::create($user->name)->toBase64() }})"></span>
                                <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                                <div class="mt-3">
                                    <span
                                        class="badge bg-purple-lt">{{ $user->roles->isNotEmpty() ? 'Role: ' . $user->getRoleDisplayNames()->implode(',') : 'No Role' }}</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group mx-3 mb-4">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                           name="avatar"/>

                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
