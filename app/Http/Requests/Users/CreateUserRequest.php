<?php

namespace App\Http\Requests\Users;

use App\Models\Roles\Role;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roles = Role::query()->pluck('name')->toArray();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'verified' => ['required', Rule::in(array_keys(User::verifyTypes()))],
            'roles' => ['required', 'array', Rule::in($roles)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:3048'],
            'avatar_type' => ['required', 'string', Rule::in(array_keys(User::avatarTypes()))],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => Str::lower(__('messages.name')),
            'email' => Str::lower(__('messages.email')),
            'verified' => Str::lower(__('messages.verified')),
            'roles' => Str::lower(__('messages.roles')),
            'password' => Str::lower(__('messages.password')),
            'avatar' => Str::lower(__('messages.avatar')),
            'avatar_type' => Str::lower(__('messages.avatar_type')),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'roles' => ! empty($this->get('roles')) ? explode(',', $this->get('roles')) : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'avatar.max' => __('messages.avatar_max_size'),
        ];
    }
}
