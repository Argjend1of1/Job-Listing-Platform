<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users, email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'logo' => ['required', File::types(['png', 'jpg', 'jpeg', 'webp'])],
            'category' => ['required'],
            'role' => ['nullable'],
            'employer' => ['nullable'],
        ];
    }
}
