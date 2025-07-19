<?php

namespace App\Http\Requests\Attendance;

use App\Models\Attendance;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAttendanceViaScanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasRole('student');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mac_address' => ['required', 'string', 'max:255', 'exists:users,mac_address']
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

    public function attributes()
    {
        return [
            'mac_address' => __('main.mac_address'),
        ];
    }

    public function after(): array
    {
        return [
            function (\Illuminate\Validation\Validator $validator) {
                if (Attendance::query()->where('lecture_id', $this->lecture->id)->where('mac_address', auth()->user()->mac_address)->exists()) {
                    $validator->errors()->add(
                        'mac_address',
                        __('main.attendance_has_already_been_recorded')
                    );
                }
            }
        ];
    }

}
