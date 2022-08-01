<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class LoadTypesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','string','min:4','max:255','distinct','unique:App\Models\LoadTypes'],
            "organisation_id"=>['required','integer']
        ];
    }
}
