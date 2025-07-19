<?php

namespace App\Http\Requests\Attendance;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasAnyRole(['admin', 'coordinator', 'chief']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'course_id' => 'sometimes|required|exists:courses,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:' . implode(',', AttendanceStatus::values()),
        ];

        if (auth()->user()->hasRole('coordinator')) {
            $rules = [
                'is_transformed' => 'required|in:0,1',
                'reject_reason' => 'required_if:is_transformed,0'
            ];
        }

        if (auth()->user()->hasRole('chief')) {
            $rules = [
                'is_approved' => 'required|in:0,1',
                'reject_reason' => 'required_if:is_approved,0'
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'course_id' =>  __('main.course'),
            'user_id' =>  __('main.student'),
            'date' =>  __('main.date'),
            'status' =>  __('main.status'),
            'is_transformed' => __('main.transform'),
            'is_approved' =>  __('main.accept'),
        ];
    }
}
