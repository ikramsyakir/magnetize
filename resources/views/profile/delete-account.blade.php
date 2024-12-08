@extends('layouts.app')

@section('title', __('Delete Account'))

@section('page-title', __('Delete Account'))

@section('breadcrumbs', Breadcrumbs::render('profile.delete-account'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">

                    @include('profile.partials.menu', ['deleteAccount' => true])

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-1">{{ __('Delete Account') }}</h2>
                            <small class="text-muted">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </small>

                            <div class="btn-list">
                                <button type="button" class="btn btn-danger mt-5" @click="openConfirmUserDeletion"
                                        :disabled="confirmUserDeletion">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="confirm-user-deletion" tabindex="-1" role="dialog" aria-hidden="false"
             @click.self="closeConfirmUserDeletion">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form autocomplete="off" @submit.prevent="submitForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Are you sure you want to delete your account?') }}</h5>
                            <button type="button" class="btn-close" @click.self="closeConfirmUserDeletion"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </div>

                            <div class="mb-3">
                                <input type="password" id="password" v-model="password" class="form-control"
                                       :class="{ 'is-invalid': errors.password }"
                                       placeholder="{{ __('messages.password') }}">
                                <div class="invalid-feedback" v-if="errors.password">@{{ errors.password[0] }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-auto" @click="closeConfirmUserDeletion">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger" :disabled="loading">
                                <span class="spinner-border spinner-border-sm border-2 me-2" role="status"
                                      aria-hidden="true" v-if="loading"></span>
                                <span>{{ __('Delete Account') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/views/profile/delete-account.js')
@endpush
