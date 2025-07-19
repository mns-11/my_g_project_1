<?php

namespace App\Http\Requests\Course;

use App\Enums\AcademicTerm;
use App\Enums\CourseType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|unique:courses|max:250',
            'code' => 'required|string|unique:courses|max:250',
            'type' => 'required|in:' . implode(',', CourseType::values()),
            'term' => 'required|in:' . implode(',', AcademicTerm::values()),
            'hours' => 'required|numeric',
            'college_id' => 'required|exists:colleges,id',
            'major_id' => 'required|exists:majors,id',
            'level_id' => 'required|exists:levels,id',
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
            'code' => __('main.code'),
        ];
    }
}
