@extends('layouts.auth.app')

@section('title', __('messages.register'))

@section('main-content')
    <div id="app" v-cloak class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}"><img src="{{ asset('images/magnetize-logo.png') }}" height="60" alt="logo"></a>
        </div>
        <form class="card card-md" autocomplete="off" @submit.prevent="submitForm">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ __('messages.create_new_account') }}</h2>

                <div class="mb-3">
                    <label for="email" class="form-label required">{{ __('messages.name') }}</label>
                    <input type="text" id="name" name="name" v-model="name" class="form-control"
                           :class="{ 'is-invalid': errors.name }">
                    <div class="invalid-feedback" v-if="errors.name">@{{ errors.name[0] }}</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label required">{{ __('messages.email') }}</label>
                    <input type="email" id="email" name="email" v-model="email" class="form-control"
                           :class="{ 'is-invalid': errors.email }">
                    <div class="invalid-feedback" v-if="errors.email">@{{ errors.email[0] }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('messages.password') }}</label>
                    <div class="input-group input-group-flat">
                        <input id="password" :type="passwordType" v-model="password" class="form-control"
                               :class="{ 'is-invalid': errors.password }">
                        <span class="input-group-text" :class="{ 'border-red': errors.password }">
                            <a class="link-secondary" @click="togglePassword"><i :class="passwordClass"></i></a>
                        </span>
                    </div>
                    <div class="invalid-feedback d-block" v-if="errors.password">@{{ errors.password[0] }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label required">{{ __('messages.password_confirmation') }}</label>
                    <div class="input-group input-group-flat">
                        <input id="password_confirmation" :type="passwordConfirmationType"
                               v-model="password_confirmation" class="form-control"
                               :class="{ 'is-invalid': errors.password_confirmation }">
                        <span class="input-group-text" :class="{ 'border-red': errors.password_confirmation }">
                            <a class="link-secondary" @click="togglePasswordConfirmation">
                                <i :class="passwordConfirmationClass"></i>
                            </a>
                        </span>
                    </div>
                    <div class="invalid-feedback d-block" v-if="errors.password_confirmation">
                        @{{ errors.password_confirmation[0] }}
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                              aria-hidden="true" v-if="loading"></span>
                        <span>{{ __('messages.register') }}</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center text-muted mt-3">
            {{ __('messages.already_have_account') }}
            <a href="{{ route('login') }}" class="btn-link">{{ __('messages.login') }}</a>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/auth/register.js')
@endpush
