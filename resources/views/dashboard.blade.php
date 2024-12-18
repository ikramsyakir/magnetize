
@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs', Breadcrumbs::render('dashboard'))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                @can('browse-users')
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-0 mt-0 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3">
                        <div class="card">
                            <div class="card-cover card-cover-blurred text-center"
                                 style="background-image: url({{ asset('images/photos/dashboard_1.jpg') }})">
                            <span class="avatar avatar-xl avatar-thumb avatar-rounded bg-green-lt"><i
                                    class="fas fa-users"></i></span>
                            </div>
                            <div class="card-body text-center">
                                <div class="card-title mb-1">{{ $total_user }} Users</div>
                                <div class="text-muted"><a href="{{ route('users.index') }}"
                                                           class="btn btn-primary btn-sm">View
                                        all users</a></div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('browse-roles')
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-0 mt-0 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3">
                        <div class="card">
                            <div class="card-cover card-cover-blurred text-center"
                                 style="background-image: url({{ asset('images/photos/dashboard_2.jpg') }})">
                                <span class="avatar avatar-xl avatar-thumb avatar-rounded bg-red-lt"><i
                                        class="fas fa-users-cog"></i></span>
                            </div>
                            <div class="card-body text-center">
                                <div class="card-title mb-1">{{ $total_role }} Roles</div>
                                <div class="text-muted"><a href="{{ route('roles.index') }}"
                                                           class="btn btn-primary btn-sm">View
                                        all roles</a></div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('browse-posts')
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-0 mt-0 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3">
                        <div class="card">
                            <div class="card-cover card-cover-blurred text-center"
                                 style="background-image: url({{ asset('images/photos/dashboard_3.jpg') }})">
                                <span class="avatar avatar-xl avatar-thumb avatar-rounded bg-purple-lt"><i
                                        class="fas fa-newspaper"></i></span>
                            </div>
                            <div class="card-body text-center">
                                <div class="card-title mb-1">{{ $total_post }} Posts</div>
                                <div class="text-muted"><a href="{{ route('posts.index') }}"
                                                           class="btn btn-primary btn-sm">View all posts</a></div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
