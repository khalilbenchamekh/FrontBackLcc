<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class LoadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'REF' => 'required','string','max:255','unique:loads,REF',
            'load_related_to' => ['exists:users,id'],
            'load_types_name' => ['exists:load_types,name'],
            'TVA' => ['nullable','in:20,14,10'],

            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ];
    }
}
