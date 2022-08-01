<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class FolderTechNatureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Name' => ['required','string','min:4','max:255','distinct','unique:App\Models\FolderTechNature'],
            'Abr_v' => ['string','max:3'],
        ];
    }
}
