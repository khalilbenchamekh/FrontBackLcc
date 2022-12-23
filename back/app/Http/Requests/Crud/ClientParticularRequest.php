<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class ClientParticularRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','string','min:4','max:255','distinct','unique:App\Models\Client'],
            'Street' => ['required','string','max:255'],
            'Street2' => ['string','max:255'],
            'city' => ['required','string','max:255'],
            'ZIP_code' => ['required','string','max:255'],
            'Country' => ['required','string','max:255'],
            'tel' => ['required','string','min:10','max:15'],
            'Cour' => ['required','string','max:255'],
            'Function' => ['required','string','max:255'],
        ];
    }
}
