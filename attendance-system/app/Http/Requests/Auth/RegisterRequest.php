<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserGender;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:70',
            'major_id' => 'required|exists:majors,id',
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-()]*$/', 'unique:users,phone', 'max:250'],
            'address' => 'sometimes|nullable|string|max:250',
            'gender' => ['required', Rule::enum(UserGender::class)],
            'birthdate' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'major_id' => __('main.major'),
            'email' => __('main.email'),
            'password' => __('main.password'),
            'address' => ucfirst(__('main.address')),
            'gender' => ucfirst(__('main.gender')),
            'birthdate' => ucwords(__('main.birth_date')),
            'phone' => ucwords(__('main.phone')),
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
