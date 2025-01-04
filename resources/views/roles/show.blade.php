@extends('layouts.app')

@section('title', __('messages.view_role'))

@section('page-title', __('messages.view_role'))

@section('breadcrumbs', Breadcrumbs::render('roles.show', $model))

@section('main-content')
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $model->display_name }}</h3>
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
                                    <td>{{ $model->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.display_name') }}</td>
                                    <td>{{ $model->display_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.description') }}</td>
                                    <td>{{ $model->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-end">{{ __('messages.permissions') }}</td>
                                    <td class="text-wrap">
                                        @forelse ($model->permissions as $permission)
                                            <span class="badge bg-blue text-blue-fg me-2 mb-1 mt-1 fs-12 pe-auto"
                                                  data-bs-toggle="tooltip" data-bs-placement="top"
                                                  title="{{ __('permissions.'.$permission->description) }}">
                                                {{ __('permissions.'.$permission->display_name) }}
                                            </span>
                                        @empty
                                            {{ __('messages.no_permission') }}
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
