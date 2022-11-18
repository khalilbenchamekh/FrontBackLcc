<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'username' => ['unique:users', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',"unique:users"],
            "password"=>['required',"required","max:225","min:6"],
            'workplace' => ['in:Ground,Office'],
            'personal_number' => ['string', 'min:10', 'max:255'],
            'profession_number' => ['string', 'min:10', 'max:255'],
            'position_held' => ['string', 'max:255'],
            'linked_documents' => ['string', 'max:255'],
            'Start_date' => ['nullable', 'date:Y-m-d'],
            'Salary' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ];
    }
}
