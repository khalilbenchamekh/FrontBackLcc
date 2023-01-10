<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => ['required_if:step,0|string|max:255'],
            'lastname' => ['required_if:step,0|string|max:255'],
            'gender' => ['nullable', 'in:female,male'],
            'address' => ['nullable', 'string', 'max:510'],
            'role' => ['exists:roles,name'],
            'name' => ["required", 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            "password"=>['required',"required","max:225","min:6"],
            'workplace' => ['in:Ground,Office'],
            'personal_number' => ['required','string', 'min:10', 'max:255'],
            'profession_number' => ['required','string', 'min:10', 'max:255'],
            'position_held' => ['required','string', 'max:255'],
            'linked_documents' => ['required','string', 'max:255'],
            'Start_date' => ['required', 'date:Y-m-d'],
            'Salary' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ];
    }
}

