<?php

namespace App\Http\Requests\Major;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMajorRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('majors')->ignore($this->route('major'))],
            'email' => ['sometimes', 'required', 'email','max:250' ,Rule::unique('majors')->ignore($this->route('major'))],
            'phone' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('majors')->ignore($this->route('major'))],
            'location' => ['sometimes', 'required', 'string', 'max:250'],
            'college_id' => ['sometimes', 'required', 'exists:colleges,id'],
            'num_levels' => ['sometimes', 'required', Rule::in([1,2,3,4,5,6,7])]

        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'location' => __('main.college_location'),
            'email' => __('main.email'),
            'phone' => __('main.phone'),
            'college_id' => __('main.college'),
            'num_levels' => __('main.num_levels'),
        ];
    }
}
