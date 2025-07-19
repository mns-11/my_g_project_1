<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'otp' => 'required|digits:4',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed|max:70'
        ];
    }

    public function attributes(): array
    {
        return [
            'otp' => __('main.otp'),
            'email' => __('main.email'),
            'password' => __('main.password'),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        if (request()->is('api/*')) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => $validator->errors(),
                ], 422)
            );
        }
    }
}
