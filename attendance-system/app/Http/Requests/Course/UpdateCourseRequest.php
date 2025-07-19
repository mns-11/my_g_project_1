<?php

namespace App\Http\Requests\Course;

use App\Enums\AcademicTerm;
use App\Enums\CourseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
        return [
            'name' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('courses')->ignore($this->route('course'))],
            'code' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('courses')->ignore($this->route('course'))],
            'type' => 'sometimes|required|in:' . implode(',', CourseType::values()),
            'term' => 'sometimes|required|in:' . implode(',', AcademicTerm::values()),
            'hours' => 'sometimes|required|numeric',
            'college_id' => 'sometimes|required|exists:colleges,id',
            'major_id' => 'sometimes|required|exists:majors,id',
            'level_id' => 'sometimes|required|exists:levels,id',
            'is_blocked' => 'sometimes|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'type' => __('main.type'),
            'term' => __('main.term'),
            'college_id' => __('main.college'),
            'major_id' => __('main.major'),
            'level_id' => __('main.level'),
            'is_blocked' => __('main.blocked_status'),
            'code' => __('main.code'),
        ];
    }
}
