<?php

namespace App\Http\Requests\Crud;


use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends MainClientRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'RC' => ['required','string','min:4','max:255','distinct','unique:App\Models\Client'],
            'ICE' => ['required','string','min:4','max:255','distinct','unique:App\Models\Client'],
        ];
    }
}
class ClientUpdateRequest extends ClientRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_mem' => ['required','string','min:4','max:255'],
        ];
    }
}
class ClientParticularRequest extends MainClientRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'Function' => ['required','string','max:255'],
        ];
    }
}
class MainClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => ['required','string','min:4','max:255','distinct','unique:App\Models\Client'],
            'tel' => ['required','string','min:10','max:15'],
            'Cour' => ['required','string','max:255'],
            'Street' => ['required','string','max:255'],
            'Street2' => ['required','string','max:255'],
            'city' => ['required','string','max:255'],
            'ZIP_code' => ['required','string','max:255'],
            'Country' => ['required','string','max:255'],
        ];
    }
}
