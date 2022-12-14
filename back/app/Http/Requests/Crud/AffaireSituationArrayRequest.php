<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class AffaireSituationArrayRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'affaireSituations'=>['required','array'],
            'affaireSituations.*.Name' =>  ['required', 'string','min:4', 'max:255', 'unique:affairesituations'],
            'affaireSituations.*.orderChr' => ['required','integer'],
        ];
    }
}
