@extends('layouts.app')

@section('title', 'New Post')

@section('breadcrumbs', Breadcrumbs::render('new_post'))

@push('styles')
    <link href="{{ asset('vendor/summernote/dist/summernote-bs4.css') }}" rel="stylesheet">
@endpush

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">New Post</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 ">
                                    <label class="form-label required" for="title">Title</label>

                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror" name="title"
                                           value="{{ old('title') }}" placeholder="Enter title" required
                                           autocomplete="title">

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="body">Body</label>
                                    <textarea class="form-control @error('body') is-invalid @enderror" name="body"
                                              id="body">{{ old('body') }}</textarea>

                                    @error('body')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="select-status">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                            id="select-status">
                                        <option disabled selected>Select</option>
                                        @foreach(\App\Models\Post::STATUS as $index => $status)
                                            <option
                                                value="{{ $index }}" {{ old('status') ? old('status') == $index ? 'selected' : '' : '' }}>{{ ucwords($status) }}</option>
                                        @endforeach
                                    </select>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input @error('featured') is-invalid @enderror"
                                               type="checkbox" name="featured"
                                               value="{{ \App\Models\Post::FEATURED }}" {{ old('featured') ? old('featured') == \App\Models\Post::FEATURED ? 'checked' : '' : '' }}>
                                        <span class="form-check-label">Featured</span>
                                    </label>

                                    @error('featured')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Image</label>

                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                           name="image"/>

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-footer text-end">
                                    <a href="{{ route('posts.index') }}" class="btn btn-link">Cancel</a>
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
    <script src="{{ asset('vendor/summernote/dist/summernote-bs4.js') }}"></script>
    <script type="text/javascript">
        $('#body').summernote({
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });
    </script>
@endpush
