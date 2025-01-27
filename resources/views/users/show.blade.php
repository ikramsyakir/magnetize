@extends('layouts.app')

@section('title', __('messages.view_user'))

@section('page-title', __('messages.view_user'))

@section('breadcrumbs', Breadcrumbs::render('users.show', $model))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $model->name }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table
                                class="table table-bordered table-striped table-vcenter text-nowrap datatable">
                                <tbody>
                                <tr>
                                    <td class="fw-semibold text-end w-25">{{ __('messages.id') }}</td>
                                    <td class="w-75">{{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.name') }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center py-1">
                                            <span class="avatar avatar-xl rounded me-3"
                                                  style="background-image: url({{ $model->getAvatarPath() }})"></span>
                                            <div class="fw-medium flex-fill">{{ $model->name }}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.email') }}</td>
                                    <td>{{ $model->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.verified') }}</td>
                                    <td class="text-wrap align-middle">
                                        @include('users.columns.email_verified_at', ['row' => $model])
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.roles') }}</td>
                                    <td class="text-wrap align-middle">
                                        @forelse ($model->roles as $role)
                                            <span class="badge bg-blue text-blue-fg me-1 mb-1 mt-1 fs-12 pe-auto"
                                                  data-bs-toggle="tooltip" data-bs-placement="top"
                                                  title="{{ $role->description }}">
                                                {{ $role->display_name }}
                                            </span>
                                        @empty
                                            {{ __('messages.no_role') }}
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.created_at') }}</td>
                                    <td>{{ $model->created_at->format('d/m/Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.updated_at') }}</td>
                                    <td>{{ $model->updated_at->diffForHumans() }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
