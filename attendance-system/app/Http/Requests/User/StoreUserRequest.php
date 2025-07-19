<?php

namespace App\Http\Requests\User;

use App\Enums\UserGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasAnyRole(['admin', 'coordinator', 'chief']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:250',
            'email' => 'required|email|unique:users,email|max:250',
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-()]*$/', Rule::unique('users')->ignore($this->route('id')), 'max:250'],
            'password' => 'required|confirmed|min:8|max:70',
            'address' => 'sometimes|nullable|string|max:250',
            'gender' => ['required', Rule::enum(UserGender::class)],
            'birthdate' => 'required|date',

        ];

        if (request()->routeIs('employees.*')) {
            $rules += [
                'role' => 'required|exists:roles,name',
            ];
        }

        if (request()->routeIs('students.*') or request()->routeIs('coordinator.students.*')) {
            $rules += [
//                'college_id' => 'required|exists:colleges,id',
//                'major_id' => 'required|exists:majors,id',
                'level_id' => 'required|exists:levels,id',
                'enrollment_number' => 'required|numeric|unique:users,enrollment_number'
            ];
        }

        if (
            request()->routeIs('students.*')
            or
            request()->routeIs('teachers.*')
            or
            request()->routeIs('chiefs.*')
            or
            request()->routeIs('coordinator.students.*')
        ) {
            $rules += [
                'major_id' => 'required|exists:majors,id',
            ];

            if(!request()->routeIs('chiefs.*')) {
                $rules += [
                    'college_id' => 'required|exists:colleges,id',
                    ];
            }
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => ucfirst(__('main.name')),
            'role' => ucfirst(__('main.role')),
            'email' => ucfirst(__('main.email')),
            'phone' => ucwords(__('main.mobile_number')),
            'password' => ucfirst(__('main.password')),
            'address' => ucfirst(__('main.address')),
            'gender' => ucfirst(__('main.gender')),
            'birthdate' => ucwords(__('main.birth_date')),
            'college_id' => ucfirst(__('main.college')),
            'major_id' => ucfirst(__('main.major')),
            'level_id' => ucfirst(__('main.level')),
            'enrollment_number' => ucfirst(__('main.enrollment_number')),

        ];
    }
}
