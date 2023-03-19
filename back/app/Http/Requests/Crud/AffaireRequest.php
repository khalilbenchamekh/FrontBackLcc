<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class AffaireRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'longitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'latitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'aff_sit_id' => ['required','exists:affairesituations,id'],
            'client_id' => ['required','exists:clients,id'],
            'resp_id' => ['required','exists:users,id'],
            'nature_name' => ['required','exists:affaire_natures,Name',"string"],
            'nature_Abr_v_name' => ['string|max:3'],
            'PTE_KNOWN' => ['required','string', 'max:255'],
            'TIT_REQ' => ['required', 'string', 'max:255'],
            'place' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'DATE_ENTRY' => ["required", 'date_format:Y-m-d H:i:s'],
            'DATE_LAI' => ['nullable', 'date:Y-m-d'],
            'Inter_id' => ['nullable', 'integer'],
            'UNITE' => ['required','integer'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
//            'ARCHIVE' => ['in:0,1'],
//            'isValidate' => ['in:0,1'],
//            'isPayed' => ['in:0,1'],
            'PRICE' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
        ];
    }
}
