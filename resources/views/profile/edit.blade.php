@php
    use App\Models\Users\User;
    use Illuminate\Support\Js;
@endphp

@extends('layouts.app')

@section('title', __('messages.profile'))

@section('page-title', __('messages.profile'))


@section('breadcrumbs', Breadcrumbs::render('profile.edit'))

@section('main-content')
    <div id="app" v-cloak class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">

                    @include('profile.partials.menu', ['profile' => true])

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-5">{{ __('Profile Information') }}</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                          :style="{ backgroundImage: `url(${avatarPreview})` }"></span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn" onclick="$('#avatar').trigger('click');">
                                        {{ __('messages.change_avatar') }}
                                    </button>
                                    <input type="file" name="avatar" id="avatar" class="d-none"
                                           @change="handleAvatarChange" accept="image/*">
                                </div>
                                <div class="col-auto">
                                    <a role="button" class="btn btn-ghost-danger" @click="deleteAvatar">
                                        {{ __('messages.delete_avatar') }}
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label required">{{ __('messages.name') }}</label>
                                        <input type="text" id="name" v-model="name" class="form-control"
                                               :class="{ 'is-invalid': errors.name }">
                                        <div class="invalid-feedback" v-if="errors.name">@{{ errors.name[0] }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label required">
                                            {{ __('messages.email') }}
                                        </label>
                                        <input type="email" id="email" v-model="email" class="form-control"
                                               :class="{ 'is-invalid': errors.email }">
                                        <div class="invalid-feedback" v-if="errors.email">@{{ errors.email[0] }}</div>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.user = {{ Js::from($user) }};
        window.avatarPreview = "{{ url(auth()->user()->getAvatarPath()) }}";
        window.avatarTypes = {{ Js::from(User::avatarTypes()) }};
        window.defaultAvatar = "{{ Avatar::create($user->name)->toBase64() }}";
    </script>
    @vite('resources/js/views/profile/edit.js')
@endpush
