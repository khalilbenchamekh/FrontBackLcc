<?php


namespace App\Request\Crud;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeDownloadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required','string','min:4','max:255','distinct','unique:App\Models\Client'],
            'filename' => ['required','string','max:255'],
        ];
    }

}
