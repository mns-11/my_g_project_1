<?php

namespace App\Http\Requests\Hall;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHallRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string','max:250' ,Rule::unique('halls')->ignore($this->route('hall'))],
            'location' => ['sometimes', 'required', 'string', 'max:250'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('main.name'),
            'location' => __('main.college_location'),
        ];
    }
}
