<?php

namespace App\Http\Requests;

use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'avatar.max' => __('messages.avatar_max_size'),
        ];
    }
}
