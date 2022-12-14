<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class ChargesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'invoiceStatus_id' => ['exists:invoicestatuses,id'],
            'typeSchargeId' => ['exists:typescharges,id'],
            'others' => ['string', 'max:255'],
            'observation' => ['string', 'max:255'],
            'desi' => ['required', 'string', 'max:255'],
            'num_quit' => ['required', 'string', 'max:255'],
            'date_fac' => ['required','nullable', 'date:Y-m-d'],
            'date_pai' => ['required','nullable', 'date:Y-m-d'],
            'date_del' => ['required','nullable', 'date:Y-m-d'],
            'unite' => ['nullable', 'integer'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'archive' => ['required','in:0,1'],
            'isPayed' => ['required','in:0,1'],
            'reste' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'avence' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'somme_due' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
        ];
    }
}
