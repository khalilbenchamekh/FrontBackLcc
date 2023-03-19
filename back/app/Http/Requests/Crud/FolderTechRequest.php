<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class FolderTechRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'aff_sit_id' => ['required', 'integer'],
            'client_id' => ['required', 'integer'],
            'resp_id' => ['required', 'integer'],
            'nature_name' => ['exists:folder_tech_natures,Name'],
            'nature_Abr_v_name' => 'string|max:3',
            'PTE_KNOWN' => ['required', 'string', 'max:255'],
            'TIT_REQ' => ['required', 'string', 'max:255'],
            'place' => ['required', 'string', 'max:255'],
            'DATE_ENTRY' => ['nullable', 'date:Y-m-d'],
            'DATE_LAI' => ['nullable', 'date:Y-m-d'],
            'Inter_id' => ['nullable', 'integer'],
            'UNITE' => ['integer'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
//            'ARCHIVE' => ['in:0,1'],
//            'isValidate' => ['in:0,1'],
//            'isPayed' => ['in:0,1'],
            'PRICE' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],

        ];
    }
}
