@extends('layouts.auth.app')

@section('title', __('messages.login'))

@section('main-content')
    <div id="app" v-cloak class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}"><img src="{{ asset('images/magnetize-logo.png') }}" height="60" alt="logo"></a>
        </div>
        <form class="card card-md" autocomplete="off">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ __('messages.login_to_your_account') }}</h2>

                <div class="mb-3">
                    <label for="email" class="form-label required">{{ __('messages.email') }}</label>
                    <input type="email" id="email" name="email" v-model="email" class="form-control"
                           :class="{ 'is-invalid': errors.email }">
                    <div class="invalid-feedback" v-if="errors.email">@{{ errors.email[0] }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label required">
                        {{ __('messages.password') }}
                        <span class="form-label-description">
                            <a href="{{ route('password.request') }}">{{ __('messages.forgot_your_password') }}</a>
                        </span>
                    </label>
                    <div class="input-group input-group-flat">
                        <input id="password" :type="passwordType" v-model="password" class="form-control"
                               :class="{ 'is-invalid': errors.password }" autocomplete="current-password">
                        <span class="input-group-text" :class="{ 'border-red': errors.password }">
                            <a class="link-secondary" @click="togglePassword">
                                <i :class="passwordClass"></i>
                            </a>
                        </span>
                    </div>
                    <div class="invalid-feedback d-block" v-if="errors.password">@{{ errors.password[0] }}</div>
                </div>

                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" id="remember" v-model="remember" class="form-check-input">
                        <span class="form-check-label">{{ __('messages.remember_me') }}</span>
                    </label>
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-primary w-100" :disabled="loading" @click.prevent="submitForm">
                        <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                              aria-hidden="true" v-if="loading"></span>
                        <span>{{ __('messages.login') }}</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center text-muted mt-3">
            <span class="me-1">{{ __('messages.dont_have_account_yet') }}</span>
            <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/auth/login.js')
@endpush
