@use(Illuminate\Support\Js)
@use(App\Models\Users\User)

@extends('layouts.app')

@section('title', __('messages.edit_user'))

@section('page-title', __('messages.edit_user'))

@section('breadcrumbs', Breadcrumbs::render('users.edit', $model))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <form autocomplete="off" @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <div class="card-subtitle">{{ __('messages.edit_user_desc') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mt-3 mb-5">
                            <div class="col-auto">
                                <span class="avatar avatar-xl"
                                      :style="{ backgroundImage: `url(${avatarPreview})` }"></span>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn" onclick="$('#avatar').trigger('click');">
                                    {{ __('messages.change_avatar') }}
                                </button>
                                <input type="file" name="avatar" id="avatar" class="d-none"
                                       @change="handleAvatarChange" ref="avatarFile" accept="image/*">
                            </div>
                            <div class="col-auto" v-if="form.avatar_type == avatarTypes.uploaded">
                                <button type="button" class="btn btn-ghost-danger" @click="deleteAvatar">
                                    {{ __('messages.delete_avatar') }}
                                </button>
                            </div>
                            <div class="invalid-feedback d-block mt-3" v-if="errors.avatar">
                                @{{ errors.avatar[0] }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label required">{{ __('messages.name') }}</label>
                                    <input type="text" id="name" v-model="form.name" class="form-control"
                                           :class="{ 'is-invalid': errors.name }">
                                    <div class="invalid-feedback" v-if="errors.name">@{{ errors.name[0] }}</div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label required">{{ __('messages.email') }}</label>
                                    <input type="email" id="email" v-model="form.email" class="form-control"
                                           :class="{ 'is-invalid': errors.email }">
                                    <div class="invalid-feedback" v-if="errors.email">
                                        @{{ errors.email[0] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="verified" class="form-label required">
                                        {{ __('messages.verified') }}
                                    </label>
                                    <select id="verified" class="form-select" v-model="form.verified"
                                            :class="{ 'is-invalid': errors.verified }">
                                        <option disabled value="">{{ __('messages.please_select') }}</option>
                                        <option v-for="(item, index) in verifyTypes" :value="index">
                                            @{{ item }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback" v-if="errors.verified">
                                        @{{ errors.verified[0] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">{{ __('messages.roles') }}</label>
                                    <div class="row mt-3">
                                        <div class="col-12" v-for="role in roles" :key="role.id">
                                            <div class="form-check mb-3">
                                                <input :id="role.name" class="form-check-input" type="checkbox"
                                                       :class="{ 'is-invalid': errors.roles }"
                                                       v-model="form.roles" :value="role.name">
                                                <label class="form-check-label align-middle" :for="role.name">
                                                    @{{ role.display_name }}
                                                    <i class="ti ti-info-circle" v-tooltip
                                                       data-bs-placement="right" :title="role.description"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback d-block" v-if="errors.roles">
                                            @{{ errors.roles[0] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label required">
                                        {{ __('messages.password') }}
                                    </label>
                                    <div class="input-group input-group-flat">
                                        <input id="password" :type="passwordType" v-model="form.password"
                                               class="form-control"
                                               :class="{ 'is-invalid': errors.password }">
                                        <span class="input-group-text"
                                              :class="{ 'border-red': errors.password }">
                                            <a class="link-secondary" @click="togglePassword">
                                                <i :class="passwordClass"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">
                                        {{ __('messages.leave_empty_to_keep_the_same') }}
                                    </small>
                                    <div class="invalid-feedback d-block" v-if="errors.password">
                                        @{{ errors.password[0] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label required">
                                        {{ __('messages.password_confirmation') }}
                                    </label>
                                    <div class="input-group input-group-flat">
                                        <input id="password_confirmation" :type="passwordConfirmationType"
                                               v-model="form.password_confirmation" class="form-control"
                                               :class="{ 'is-invalid': errors.password_confirmation }">
                                        <span class="input-group-text"
                                              :class="{ 'border-red': errors.password_confirmation }">
                                            <a class="link-secondary" @click="togglePasswordConfirmation">
                                                <i :class="passwordConfirmationClass"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback d-block" v-if="errors.password_confirmation">
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
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.model = {{ Js::from($model) }};
        window.currentRoles = {{ Js::from($currentRoles) }};
        window.roles = {{ Js::from($roles) }};
        window.avatarTypes = {{ Js::from(User::avatarTypes()) }};
        window.avatarPreview = "{{ $model->getAvatarPath() }}";
        window.defaultAvatar = "{{ Avatar::create($model->name)->toBase64() }}";
        window.verifyTypes = {{ Js::from(User::verifyTypes()) }};
    </script>
    @vite('resources/js/views/users/edit.js')
@endpush
