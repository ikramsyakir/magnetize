@extends('layouts.app')

@section('title', 'Edit Role')

@section('breadcrumbs', Breadcrumbs::render('edit_role', $role))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('roles.update', $role->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Role</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label required" for="name">Name</label>

                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}" placeholder="Enter name" required autocomplete="name">

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label required" for="display_name">Display Name</label>

                                            <input id="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name" value="{{ $role->display_name }}" placeholder="Enter Display Name" required autocomplete="display_name">

                                            @error('display_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Description</label>

                                    <textarea id="description" name="description" class="form-control" data-bs-toggle="autosize" placeholder="Enter Description">{{ $role->description }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Permissions</label>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <label class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                       @if(old('permissions'))
                                                           {{ (is_array(old('permissions')) and in_array($permission->id, old('permissions'))) ? ' checked' : '' }}
                                                       @else
                                                           @foreach($role->permissions->pluck('id') as $item)
                                                               {{ $item == $permission->id ? ' checked' : '' }}
                                                           @endforeach
                                                       @endif
                                                    >
                                                    <span class="form-check-label">{{ $permission->display_name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-footer text-end">
                                    <a href="{{ route('roles.index') }}" class="btn btn-link">Cancel</a>
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
