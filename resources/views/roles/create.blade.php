@use(Illuminate\Support\Js)

@extends('layouts.app')

@section('title', __('messages.create_role'))

@section('page-title', __('messages.create_role'))

@section('breadcrumbs', Breadcrumbs::render('roles.create'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <form autocomplete="off" @submit.prevent="submitForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-subtitle">
                            {{ __('messages.create_a_new_role_to_manage_user_permissions') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label required">{{ __('messages.name') }}</label>
                                    <input type="text" id="name" v-model="form.name" class="form-control"
                                           :class="{ 'is-invalid': errors.name }">
                                    <div class="invalid-feedback" v-if="errors.name">@{{ errors.name[0] }}</div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="display_name" class="form-label required">
                                        {{ __('messages.display_name') }}
                                    </label>
                                    <input type="text" id="display_name" v-model="form.display_name"
                                           class="form-control" :class="{ 'is-invalid': errors.display_name }">
                                    <div class="invalid-feedback" v-if="errors.display_name">
                                        @{{ errors.display_name[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ __('messages.description') }}</label>
                                    <textarea id="description" v-model="form.description" class="form-control"
                                              :class="{ 'is-invalid': errors.description }"></textarea>
                                    <div class="invalid-feedback" v-if="errors.description">
                                        @{{ errors.description[0] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.permissions') }}</label>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12"
                                             v-for="permission in permissions" :key="permission.id">
                                            <label class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                       v-model="form.permissions" :value="permission.name">
                                                <span class="form-check-label align-middle">
                                                    @{{ permission.display_name }}
                                                    <i class="ti ti-info-circle" v-tooltip
                                                       :title="permission.description"></i>
                                                </span>
                                            </label>
                                        </div>

                                        <div class="invalid-feedback d-block" v-if="errors.permissions">
                                            @{{ errors.permissions[0] }}
                                        </div>
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
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.permissions = {{ Js::from($permissions) }};
    </script>
    @vite('resources/js/views/roles/create.js')
@endpush
