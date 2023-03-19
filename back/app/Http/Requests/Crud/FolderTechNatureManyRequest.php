<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class FolderTechNatureManyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'folderTechNature.*.Name' => ['required','string','unique:folder_tech_natures','min:4','max:255'],
            'folderTechNature.*.Abr_v' => ['string','max:3'],
        ];
    }
}
