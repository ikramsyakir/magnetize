@extends('layouts.app')

@section('title', 'View Post')

@section('breadcrumbs', Breadcrumbs::render('view_post', $post))

@if(Auth::user()->hasRole('admin') || $post->author_id == Auth()->user()->id)
    @section('button')
        <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-primary">Edit</a>
    @endsection
@endif

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $post->title }}</h3>
                        </div>
                        <div class="card-body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-0 mt-0 mt-xl-0 mt-lg-0 mt-md-3 mt-sm-3">
                    <div class="card">
                        @if($post->image)
                            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url({{ asset($post->image) }})"></div>
                        @endif
                        <div class="card-body">
                            <div class="card-title">Post info</div>
                            <div class="mb-2">
                                <i class="fas fa-info-circle"></i>
                                Status: <strong>{{ ucwords(strtolower($post->status)) }}</strong>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-crown"></i>
                                Featured:
                                <strong>
                                    @if($post->featured == 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </strong>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock"></i>
                                Created at: <strong>{{ $post->created_at->format('d/m/Y h:i A') }}</strong>
                            </div>
                            <div>
                                <i class="fas fa-history"></i>
                                Updated at: <strong>{{ $post->updated_at->diffForHumans() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
