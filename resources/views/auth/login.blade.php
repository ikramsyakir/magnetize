@extends('layouts.auth.app')

@section('title', 'Login')

@section('main-content')
    <div id="app" class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}"><img src="{{ asset('images/magnetize-logo.png') }}" height="60" alt=""></a>
        </div>
        <form class="card card-md" action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf

            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login to your account</h2>
                <div class="mb-3">
                    <label class="form-label">Username / Email</label>
                    <input id="login" type="text"
                           class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                           name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                    @if ($errors->has('username') || $errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Password
                        <span class="form-label-description">
                            <a href="{{ route('password.request') }}">I forgot password</a>
                        </span>
                    </label>

                    <div id="show_hide_password" class="input-group input-group-flat">
                        <input id="password" :type="passwordType"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">
                        <span class="input-group-text">
                            <a class="link-secondary" title="Show password" @click="togglePassword">
                                <i :class="passwordClass"></i>
                            </a>
                        </span>
                    </div>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/auth/login.js')
@endpush
