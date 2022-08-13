<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class AffaireNatureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Name' => ['required','string','min:4','max:255','distinct','unique:App\Models\AffaireNature'],
            'Abr_v' => ['string','max:3'],
            'organisation_id'=>["required","integer"]
        ];
    }
}

class AffaireNatureArrayRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'affaires.*.Name' => ['required','string','min:4','max:255','distinct','unique:App\Models\AffaireNature'],
            'affaires.*.Abr_v' => 'required|string|max:3',
        ];
    }
}



