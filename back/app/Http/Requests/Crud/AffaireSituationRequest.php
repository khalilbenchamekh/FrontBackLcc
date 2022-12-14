<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class AffaireSituationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Name' => ['required', 'string','min:4', 'max:255', 'unique:affairesituations'],
            'orderChr' => ['required','integer'],
        ];
    }
}
