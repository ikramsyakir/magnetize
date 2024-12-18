<div id="filter"
     class="col-12 mb-3 collapse {{ request()->anyFilled(['title', 'status', 'featured']) ? 'show' : '' }}">
    <div class="card">
        <form method="GET" action="{{ route('posts.index') }}" enctype="multipart/form-data">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-filter"></i> Filter</h3>

                <div class="row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input id="title" type="text" class="form-control " name="title"
                                           value="{{ request()->get('title') }}" placeholder="Enter title"
                                           autocomplete="title">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="select-status">Status</label>
                                    <select name="status" class="form-select" id="select-status">
                                        <option disabled selected>Select</option>
                                        @foreach(\App\Models\Posts\Post::STATUS as $index => $status)
                                            <option
                                                value="{{ $index }}" {{ request()->get('status') == $index ? 'selected' : '' }}>{{ ucwords($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="select-status">Featured</label>
                                    <select name="featured" class="form-select" id="select-featured">
                                        <option disabled selected>Select</option>
                                        <option
                                            value="{{ \App\Models\Posts\Post::FEATURED }}" {{ request()->has('featured') ? request()->get('featured') == \App\Models\Posts\Post::FEATURED ? 'selected' : '' : '' }}>
                                            Yes
                                        </option>
                                        <option
                                            value="{{ \App\Models\Posts\Post::NOT_FEATURED }}" {{ request()->has('featured') ? request()->get('featured') == \App\Models\Posts\Post::NOT_FEATURED ? 'selected' : '' : '' }}>
                                            No
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Card footer -->
            <div class="card-footer">
                <div class="d-flex">
                    <a href="#" class="btn btn-link" data-toggle="collapse" data-target="#filter">Close</a>
                    <div class="ms-auto">
                        <a href="{{ route('posts.index') }}" class="btn btn-link">Clear</a>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
