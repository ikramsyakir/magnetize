@extends('layouts.app')

@section('title', 'Posts')

@section('breadcrumbs', Breadcrumbs::render('posts'))

@section('button')
    @can('create-post')
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add New</a>
    @endcan
    <a href="#" class="btn btn-light" data-toggle="collapse" data-target="#filter">Filter</a>
@endsection

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            @include('posts.index-filter')

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Posts</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                            <tr>
                                <th>@sortablelink('title', 'Title')</th>
                                <th>Post Image</th>
                                <th>@sortablelink('status', 'Status')</th>
                                <th class="text-center">@sortablelink('featured', 'Featured')</th>
                                <th>@sortablelink('user.name', 'Author')</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $item)
                                <tr>
                                    <td>{{ \Illuminate\Support\Str::limit($item->title, 20) }}</td>
                                    <td>
                                        @if($item->image)
                                            <span class="avatar avatar-xl" style="background-image: url({{ $item->image }})"></span>
                                        @else
                                            <span class="avatar avatar-xl">{{ \Illuminate\Support\Str::limit($item->title, 2, '') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->status }}</td>
                                    <td class="text-center">
                                        @if($item->featured == 1)
                                            <i class="fas fa-star text-primary"></i>
                                        @else
                                            <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </td>
                                    <td>{{ $item->user->name }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-ghost-light align-text-top" href="#" role="button"
                                               data-toggle="dropdown" data-boundary="window">
                                                <i class="fas fa-ellipsis-h text-muted"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('read-post')
                                                    <a class="dropdown-item"
                                                       href="{{ route('posts.show', $item->slug) }}">View</a>
                                                @endcan
                                                @if(Auth::user()->hasRole('admin') || $item->author_id == Auth()->user()->id)
                                                    <a class="dropdown-item"
                                                       href="{{ route('posts.edit', $item->slug) }}">Edit</a>
                                                @endif
                                                @if(Auth::user()->hasRole('admin') || $item->author_id == Auth()->user()->id)
                                                    <a class="dropdown-item" href="#"
                                                       onclick="confirmDelete('{{ route('posts.destroy', $item->id) }}');">Delete</a>
                                                @endif
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

                    @include('partials.pagination', ['items' => $posts])

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.delete-item')
@endpush
