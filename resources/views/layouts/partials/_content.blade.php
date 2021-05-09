<div class="container-xl">
    <!-- Page title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                @yield('breadcrumbs')
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    @yield('button')
                </div>
            </div>
        </div>
    </div>
</div>

@yield('main-content')
