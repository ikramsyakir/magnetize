<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/magnetize-logo.png') }}" width="110" height="32"
                     alt="{{ config('app.name') }}" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
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
                       onclick="event.preventDefault();document.getElementById('nav-logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="nav-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-dashboard fs-2"></i>
                        </span>
                        <span class="nav-link-title">
                            {{ __('messages.dashboard') }}
                        </span>
                    </a>
                </li>
                @canany(['create-user', 'read-user', 'delete-user'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-users fs-2"></i>
                        </span>
                            <span class="nav-link-title">
                            {{ __('messages.users') }}
                        </span>
                        </a>
                    </li>
                @endcanany
                @canany(['create-role', 'read-role', 'update-role', 'delete-role'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-user-cog fs-2"></i>
                        </span>
                            <span class="nav-link-title">
                            {{ __('messages.roles') }}
                        </span>
                        </a>
                    </li>
                @endcanany
                @canany(['create-permission', 'read-permission', 'update-permission', 'delete-permission'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-user-shield fs-2"></i>
                        </span>
                            <span class="nav-link-title">
                            {{ __('messages.permissions') }}
                        </span>
                        </a>
                    </li>
                @endcanany
                @canany(['create-post', 'read-post', 'update-post', 'delete-post'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-news fs-2"></i>
                        </span>
                            <span class="nav-link-title">
                            {{ __('messages.posts') }}
                        </span>
                        </a>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</aside>
