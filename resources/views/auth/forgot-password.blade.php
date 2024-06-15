@extends('layouts.auth.app')

@section('title', __('messages.forgot_password'))

@section('main-content')
    <div id="app" v-cloak class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}"><img src="{{ asset('images/magnetize-logo.png') }}" height="60" alt="logo"></a>
        </div>
        <form class="card card-md" autocomplete="off" @submit.prevent="submitForm">
            <div class="card-body">
                <div class="alert alert-important bg-green-lt text-center mb-4" role="alert" v-if="reset_link_sent">
                    @{{ reset_link_sent }}
                </div>

                <h2 class="card-title text-center mb-4">{{ __('messages.reset_password') }}</h2>

                <p class="text-muted mb-4">
                    {{ __('messages.forgot_your_password_no_problem_just_let_us_know_your_email_address_and_we_will_email_you_a_password_reset_link_that_will_allow_you_to_choose_a_new_one') }}
                </p>

                <div class="mb-3">
                    <label for="email" class="form-label required">{{ __('messages.email') }}</label>
                    <input type="email" id="email" name="email" v-model="email" class="form-control"
                           :class="{ 'is-invalid': errors.email }">
                    <div class="invalid-feedback" v-if="errors.email">@{{ errors.email[0] }}</div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                              aria-hidden="true" v-if="loading"></span>
                        <i class="fa fa-envelope me-2"></i>
                        <span>{{ __('messages.send_password_reset_link') }}</span>
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            {{ __('messages.forget_it') }},
            <a href="{{ route('login') }}" class="btn-link">{{ __('messages.send_me_back') }}</a>
            {{ __('messages.to_the_login_screen') }}
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/auth/forgot-password.js')
@endpush
