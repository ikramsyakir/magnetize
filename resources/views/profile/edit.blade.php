@extends('layouts.app')

@section('title', __('messages.profile'))

@section('page-title', __('messages.profile'))


@section('breadcrumbs', Breadcrumbs::render('profile.edit'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">{{ __('messages.manage_account') }}</h4>
                            <div class="list-group list-group-transparent">
                                <a href="#"
                                   class="list-group-item list-group-item-action d-flex align-items-center active">
                                    {{ __('Profile Information') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    {{ __('Update Password') }}
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    {{ __('Delete Account') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-5">{{ __('Profile Information') }}</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                          style="background-image: url(./static/avatars/000m.jpg)"></span>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn">Change avatar</a>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-ghost-danger">Delete avatar</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <div>
                                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Email address</label>
                                        <div>
                                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
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
