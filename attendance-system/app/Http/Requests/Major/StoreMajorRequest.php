<?php

namespace App\Http\Requests\Major;

use Illuminate\Foundation\Http\FormRequest;

class StoreMajorRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:majors,name',
            'location' => 'required|string|max:250',
            'email' => 'required|email|unique:majors,email|max:250',
            'phone' => 'required|string|unique:majors,phone|max:250',
            'college_id' => 'required|exists:colleges,id',
            'num_levels' => 'required|in:1,2,3,4,5,6,7'
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
