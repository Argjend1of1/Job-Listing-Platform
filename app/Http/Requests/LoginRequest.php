<?php

namespace App\Http\Requests;

use App\Enums\ServerStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
            'email'     => ['required', 'email'],
            'password'  => ['required', Password::min(6)],
            //example of enum usage:
//            'enum'      =>  [
//                Rule::enum(ServerStatus::class)
//                    ->only([ServerStatus::Pending, ServerStatus::Active])
//            ]
        ];
    }
}
