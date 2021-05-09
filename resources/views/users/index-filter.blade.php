<div id="filter"
     class="col-12 mb-3 collapse {{ request()->anyFilled(['name', 'email', 'username', 'status', 'roles']) ? 'show' : '' }}">
    <div class="card">
        <form method="GET" action="{{ route('users.index') }}" enctype="multipart/form-data">
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

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="email">Email address</label>
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ request()->get('email') }}" placeholder="Enter Email"
                                           autocomplete="email">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ request()->get('username') }}" placeholder="Enter Username"
                                           autocomplete="username">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="select-status">Status</label>
                                    <select name="status" class="form-select" id="select-status">
                                        <option disabled selected>Select</option>
                                        <option value="1" {{ request()->get('status') == 1 ? 'selected' : '' }}>
                                            Verified
                                        </option>
                                        <option value="2" {{ request()->get('status') == 2 ? 'selected' : '' }}>
                                            Unverified
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="select-role">Roles</label>
                                    <select name="roles" class="form-select" id="select-role">
                                        <option disabled selected>Select</option>
                                        @foreach($roles as $name => $display_name)
                                            <option
                                                value="{{ $name }}" {{ request()->get('roles') == $name ? 'selected' : '' }}>{{ $display_name }}</option>
                                        @endforeach
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
                        <a href="{{ route('users.index') }}" class="btn btn-link">Clear</a>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
