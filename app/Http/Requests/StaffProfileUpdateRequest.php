<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

     public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'names' => ['string', 'max:255'],
            'phone_number' => ['string', 'max:255'],
            'role' => ['string', 'max:255'],
          	'percentage' => ['nullable', 'string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique('staff') -> ignore($this -> staff_id)],
			'work_phone' => ['string', 'max:255'],
            'department_id' => ['integer', 'max:255'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $department = Department::find($this->department_id);

            if ($department && $department->name === 'Applications' && !$this->percentage) {
                $validator->errors()->add(
                    'percentage', 
                    'The percentage field is required when the department is Applications.'
                );
            }
        });
    }

}
