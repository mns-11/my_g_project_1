<?php

namespace App\Http\Requests\Attendance;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and (auth()->user()->hasRole('admin') or auth()->user()->hasRole('teacher'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:' . implode(',', AttendanceStatus::values()),
        ];
    }

    public function attributes()
    {
        return [
            'course_id' =>  __('main.course'),
            'user_id' =>  __('main.student'),
            'date' =>  __('main.date'),
            'status' =>  __('main.status'),
        ];
    }
}
