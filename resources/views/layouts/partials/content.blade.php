<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    @yield('page-title')
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                @yield('breadcrumbs')
            </div>
        </div>
    </div>
</div>

@yield('main-content')
