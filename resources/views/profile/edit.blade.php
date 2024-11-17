@extends('layouts.app')

@section('title', __('messages.profile'))

@section('page-title', __('messages.profile'))


@section('breadcrumbs', Breadcrumbs::render('profile.edit'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">

                    @include('profile.partials.menu', ['profile' => true])

                    <div id="app" class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-5">{{ __('Profile Information') }}</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                          style="background-image: url({{ auth()->user()->getAvatarPath() }})"></span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn" onclick="$('#avatar').trigger('click');">
                                        {{ __('messages.change_avatar') }}
                                    </button>
                                    <input type="file" name="avatar" id="avatar" class="d-none">
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-ghost-danger">{{ __('messages.delete_avatar') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <div>
                                            <input type="email" class="form-control" aria-describedby="emailHelp"
                                                   placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Email address</label>
                                        <div>
                                            <input type="email" class="form-control" aria-describedby="emailHelp"
                                                   placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list">
                                <a href="#" class="btn btn-primary">{{ __('Save') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/profile/edit.js')
@endpush
