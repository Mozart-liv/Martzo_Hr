<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'name' => 'required',
            'email' => 'required|unique:users,email'.$this->id,
            'password' => 'required|min:6',
            'phone' => 'required|min:9',
            'nrc' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'date_of_join' => 'required',
            'role_id' => 'required'
        ];
    }
}
