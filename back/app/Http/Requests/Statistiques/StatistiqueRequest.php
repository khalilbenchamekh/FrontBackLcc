<?php

namespace App\Http\Requests\Statistiques;

use Illuminate\Foundation\Http\FormRequest;

class StatistiqueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' =>'required|in:global,client,employee',
            'rapport' =>'in:financier,tva,ca',
            'from' => [ 'date:Y-m-d'],
            'to' => [ 'date:Y-m-d'],
            'orderBy' => 'in:year,month',
            'resp_id' => 'exists:users,id',
            'client_id' => 'exists:clients,id',
        ];
    }
}
