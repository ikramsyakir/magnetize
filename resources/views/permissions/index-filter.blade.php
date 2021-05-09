<div id="filter"
     class="col-12 mb-3 collapse {{ request()->anyFilled(['name']) ? 'show' : '' }}">
    <div class="card">
        <form method="GET" action="{{ route('permissions.index') }}" enctype="multipart/form-data">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-filter"></i> Filter</h3>

                <div class="row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input id="name" type="text" class="form-control " name="name"
                                           value="{{ request()->get('name') }}" placeholder="Enter name"
                                           autocomplete="name">
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
                        <a href="{{ route('permissions.index') }}" class="btn btn-link">Clear</a>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
