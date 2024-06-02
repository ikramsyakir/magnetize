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
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                </li>
                @canany(['create-user', 'read-user', 'delete-user'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-users"></i>
                        </span>
                            <span class="nav-link-title">
                            Users
                        </span>
                        </a>
                    </li>
                @endcanany
                @canany(['create-role', 'read-role', 'update-role', 'delete-role'])
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-users-cog"></i>
                        </span>
                        <span class="nav-link-title">
                            Roles
                        </span>
                    </a>
                </li>
                @endcanany
                @canany(['create-permission', 'read-permission', 'update-permission', 'delete-permission'])
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-shield-alt"></i>
                        </span>
                        <span class="nav-link-title">
                            Permissions
                        </span>
                    </a>
                </li>
                @endcanany
                @canany(['create-post', 'read-post', 'update-post', 'delete-post'])
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fas fa-newspaper"></i>
                        </span>
                        <span class="nav-link-title">
                            Posts
                        </span>
                    </a>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</aside>
