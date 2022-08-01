<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class MissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => 'required|string|max:255|unique:missions,text',
            'Description' => ['string', 'max:255'],
            'startDate' => [ 'date:Y-m-d'],
            'endDate' => [ 'date:Y-m-d'],
        ];
    }
}
