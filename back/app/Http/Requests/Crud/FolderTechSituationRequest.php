<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class FolderTechSituationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Name' => ['required', 'string', 'max:255', 'unique:foldertechsituations'],
            'orderChr' => ['required','integer'],
        ];
    }
}
