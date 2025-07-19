<?php

namespace App\Http\Requests\AcademicYearCollegeCourseHallMajorUser;

use App\Enums\CourseType;
use App\Models\AcademicYearCollegeCourseHallMajorUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateAcademicYearCollegeCourseHallMajorUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return  [
            'college_id' => 'sometimes|required|exists:colleges,id',
            'major_id' => 'sometimes|required|exists:majors,id',
//            'level_id' => 'sometimes|required|exists:levels,id',
            'hall_id' => 'sometimes|required|exists:halls,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'academic_year_id' => 'sometimes|required|exists:academic_years,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'type' => 'sometimes|required|in:' . implode(',', CourseType::values()),
        ];
    }

    public function attributes()
    {
        return [
            'course_id' => __('main.course'),
            'type' => __('main.type'),
            'college_id' => __('main.college'),
            'major_id' => __('main.major'),
//            'level_id' => __('main.level'),
            'hall_id' => __('main.hall'),
            'academic_year_id' => __('main.academic_year'),
            'user_id' => __('main.responsible_doctor'),
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->isCourseAssignedBefore()) {
                    $validator->errors()->add(
                        'user_id',
                        __('main.course_already_assigned_to_this_doctor')
                    );
                }
            }
        ];
    }

    private function isCourseAssignedBefore()
    {
        return AcademicYearCollegeCourseHallMajorUser::query()
            ->where('course_id', $this->course_id)
            ->where('user_id', $this->user_id)
            ->where('academic_year_id', $this->academic_year_id)
            ->where('major_id', $this->major_id)
            ->where('type', $this->type)
            ->where('hall_id', $this->hall_id)
            ->exists();
    }
}
