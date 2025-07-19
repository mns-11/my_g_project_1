<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetAttendancesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasAnyRole(['student', 'admin', 'teacher', 'coordinator', 'chief']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'nullable|exists:courses,id'
        ];
    }

    public function attributes()
    {
        return [
            'course_id' =>  __('main.course'),
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
