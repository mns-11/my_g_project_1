<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCollegeRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('colleges')->ignore($this->route('college'))],
            'email' => ['sometimes', 'required', 'email','max:250' ,Rule::unique('colleges')->ignore($this->route('college'))],
            'phone' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('colleges')->ignore($this->route('college'))],
            'location' => ['sometimes', 'required', 'string', 'max:250']

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
