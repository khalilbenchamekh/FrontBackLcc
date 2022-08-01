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
            'Name' => ['required','string','min:4','max:255','distinct'],
            'Abr_v' => ['string','max:3'],
            'organisation_id'=>["required","integer"]
        ];
    }
}
