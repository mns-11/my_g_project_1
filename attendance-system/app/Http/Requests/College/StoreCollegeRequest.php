<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollegeRequest extends FormRequest
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
            'name' => 'required|string|max:250|unique:colleges,name',
            'location' => 'required|string|max:250',
            'email' => 'required|email|unique:colleges,email|max:250',
            'phone' => 'required|string|unique:colleges,phone|max:250',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'location' => __('main.college_location'),
            'email' => __('main.email'),
            'phone' => __('main.phone'),
        ];
    }
}
