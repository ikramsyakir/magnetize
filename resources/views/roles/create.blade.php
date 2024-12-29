@use(Illuminate\Support\Js)

@extends('layouts.app')

@section('title', __('messages.create_role'))

@section('page-title', __('messages.create_role'))

@section('breadcrumbs', Breadcrumbs::render('roles.create'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <form method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-muted">
                                    {{ __('messages.create_a_new_role_to_manage_user_permissions') }}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group mb-3 ">
                                            <label class="form-label required" for="name">Name</label>

                                            <input id="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                                   value="{{ old('name') }}" placeholder="Enter name" required
                                                   autocomplete="name">

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

                                            <input id="display_name" type="text"
                                                   class="form-control @error('display_name') is-invalid @enderror"
                                                   name="display_name" value="{{ old('display_name') }}"
                                                   placeholder="Enter Display Name" required
                                                   autocomplete="display_name">

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

                                    <textarea id="description" name="description" class="form-control"
                                              data-bs-toggle="autosize"
                                              placeholder="Enter Description">{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Permissions</label>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"
                                             v-for="permission in permissions" :key="permission.id">
                                            <label class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                       :value="permission.id">
                                                <span class="form-check-label align-middle">
                                                    @{{ permission.display_name }}
                                                     <i class="ti ti-info-circle" v-tooltip
                                                        :title="permission.description"></i>
                                                </span>
                                            </label>
                                        </div>
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

@push('scripts')
    <script>
        window.permissions = {{ Js::from($permissions) }};
    </script>
    @vite('resources/js/views/roles/create.js')
@endpush
