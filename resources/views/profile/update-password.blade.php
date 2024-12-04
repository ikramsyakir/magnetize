@use(Illuminate\Support\Js)

@extends('layouts.app')

@section('title', __('Update Password'))

@section('page-title', __('Update Password'))

@section('breadcrumbs', Breadcrumbs::render('profile.update-password'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">

                    @include('profile.partials.menu', ['updatePassword' => true])

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form autocomplete="off" @submit.prevent="submitForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="mb-1">{{ __('Update Password') }}</h2>
                                <small class="text-muted">
                                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                </small>
                                <div class="row mt-5">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label required">
                                                {{ __('Current Password') }}
                                            </label>
                                            <input type="password" id="current_password" v-model="current_password"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': errors.current_password }">
                                            <div class="invalid-feedback" v-if="errors.current_password">
                                                @{{ errors.current_password[0] }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label required">
                                                {{ __('New Password') }}
                                            </label>
                                            <input type="password" id="password" v-model="password"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': errors.password }">
                                            <div class="invalid-feedback" v-if="errors.password">
                                                @{{ errors.password[0] }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label required">
                                                {{ __('Confirm Password') }}
                                            </label>
                                            <input type="password" id="password_confirmation" v-model="password_confirmation"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': errors.password_confirmation }">
                                            <div class="invalid-feedback" v-if="errors.password_confirmation">
                                                @{{ errors.password_confirmation[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                                          aria-hidden="true" v-if="loading"></span>
                                        <span>{{ __('Save') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.user = {{ Js::from($user) }};
    </script>
    @vite('resources/js/views/profile/update-password.js')
@endpush
