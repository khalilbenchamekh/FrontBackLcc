<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;


// class ClientUpdateRequest extends FormRequest
// {
//     public function authorize()
//     {
//         return true;
//     }

//     public function rules()
//     {
//         return [
//             'id_mem' => ['required','string','min:4','max:255'],
//         ];
//     }
// }

class ClientRequest extends FormRequest
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
            'id_mem' => ['required','string','min:4','max:255'],
        ];
    }
}
