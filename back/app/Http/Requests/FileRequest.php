<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filename' => ['required'],
            'filename.*' => ['mimes:doc,pdf,docx,zip,jpg,png,rar,gif','not_in:exe,js,ts,dll,sql']
        ];
    }
}
