@extends('layouts.app')

@section('title', __('messages.confirm_password'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-4">
                                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                            </p>

                            <form autocomplete="off" @submit.prevent="submitForm">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('messages.password') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input id="password" :type="passwordType" v-model="password"
                                               class="form-control"
                                               :class="{ 'is-invalid': errors.password }"
                                               autocomplete="current-password">
                                        <span class="input-group-text" :class="{ 'border-red': errors.password }">
                                            <a class="link-secondary" @click="togglePassword">
                                                <i :class="passwordClass"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback d-block" v-if="errors.password">
                                        @{{ errors.password[0] }}
                                    </div>
                                </div>

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                                          aria-hidden="true" v-if="loading"></span>
                                        <span>{{ __('messages.confirm') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    @vite('resources/js/views/auth/confirm-password.js')
@endpush
