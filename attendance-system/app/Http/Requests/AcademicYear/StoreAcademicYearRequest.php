<?php

namespace App\Http\Requests\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        return auth()->check() and auth()->user()->hasRole('admin');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:academic_years,name',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'start_date' => __('main.start_date'),
            'end_date' => __('main.end_date'),
        ];
    }
}
