@extends('layouts.app')

@section('title', 'New User')

@section('breadcrumbs', Breadcrumbs::render('new_user'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">New User</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 ">
                                    <label class="form-label required" for="name">Name</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter name" required autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3 ">
                                    <label class="form-label required" for="username">Username</label>

                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="johndoe" required autocomplete="username">

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="email">Email address</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="johndoe@email.com" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="password">Password</label>

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Must have at least 8 characters" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="password-confirm">Confirm Password</label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="select-status">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" id="select-status">
                                        <option disabled selected>Select</option>
                                        <option value="1">Verified</option>
                                        <option value="2">Unverified</option>
                                    </select>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-label required">Roles</div>
                                    <div>
                                        @foreach($roles as $role)
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox" name="roles[]" value="{{ $role->name }}">
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
                                <div class="form-group mb-3">
                                    <label class="form-label">Picture</label>

                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" />

                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-footer text-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
