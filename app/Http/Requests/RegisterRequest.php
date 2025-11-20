<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'category' => ['required'],
            'logo' => ['nullable', 'image', /*File::types(['png', 'jpg', 'jpeg', 'webp'])*/],
            'role' => ['nullable'],
            'employer' => [Rule::requiredIf(fn () => $this->input('is_company'))],
        ];
    }

    public function storeLogo(): ?string
    {
        if ($this->hasFile('logo')) {
            return $this->file('logo')
                        ->store('logos', 'public');
        }
        return null;
    }
}
