<?php

namespace App\Http\Requests\Hall;

use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
{
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
            'name' => 'required|string|max:250|unique:halls,name',
            'location' => 'required|string|max:250',
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
