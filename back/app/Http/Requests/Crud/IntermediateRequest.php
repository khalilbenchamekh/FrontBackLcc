<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class IntermediateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name"=>["required","max:225","min:3"],
            "second_name"=>["required","max:225","min:3"],
            "Street"=>["required","max:225","min:3"],
            "Street2"=>["required","max:225","min:3"],
            "city"=>["required","max:225","min:3"],
            "ZIP_code"=>["required","max:225","min:3"],
            "Country"=>["required","max:225","min:3"],
            "Function"=>["required","max:225","min:3"],
            "tel"=>["required","max:225","min:3"],
            "Cour"=>["required","max:225","min:3"],
            "fees"=>["max:225","min:3"]
        ];
    }
}
