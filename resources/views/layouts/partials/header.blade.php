@php
    use App\Utilities\Theme;
    use Illuminate\Support\Js;
@endphp
<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <div id="header" v-cloak class="d-none d-md-flex">
                <a class="nav-link px-0 hide-theme-dark" title="{{ __('messages.enable_dark_mode') }}"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" role="button" @click="toggleTheme">
                    <i class="ti ti-moon fs-2"></i>
                </a>
                <a class="nav-link px-0 hide-theme-light" title="{{ __('messages.enable_light_mode') }}"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" role="button" @click="toggleTheme">
                    <i class="ti ti-sun fs-2"></i>
                </a>
            </div>

            @include('layouts/partials/notification')

            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                          style="background-image: url({{ auth()->user()->getAvatarPath() }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    @can('user-profile')
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            {{ __('messages.profile') }}
                        </a>
                    @endcan
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('header-logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="header-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu"></div>
    </div>
</header>

@push('scripts')
    <script>
        window.themeType = {{ Js::from(Theme::themeType()) }};
    </script>
    @vite('resources/js/views/layouts/partials/header.js')
@endpush
