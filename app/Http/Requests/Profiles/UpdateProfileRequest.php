<?php

namespace App\Http\Requests\Profiles;

use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:3048'],
            'avatar_type' => ['required', 'string', Rule::in(array_keys(User::avatarTypes()))],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => Str::lower(__('messages.name')),
            'email' => Str::lower(__('messages.email')),
            'avatar' => Str::lower(__('messages.avatar')),
            'avatar_type' => Str::lower(__('messages.avatar_type')),
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.max' => __('messages.avatar_max_size'),
        ];
    }
}
