<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class GreatConstructionSitesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'location_id' => ['exists:locations,id'],
            'Market_title' => 'required|string|max:255|unique:g_c_s,Market_title',
            'resp_id' => ['exists:users,id'],
            'client_id' => ['exists:clients,id'],
            '*.Execution_report.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'Execution_report.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            '*.Class_service.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'Class_service.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'Execution_phase' => ['string', 'max:255'],
            'allocated_brigades' => ['string', 'max:255'],
            'State_of_progress' => ['nullable','in:En cours,Teminé,En Attente de validation,Annulé'],
            'DATE_LAI' => ['date_format:Y/m/d'],
            'date_of_receipt' => ['date_format:Y/m/d'],
            'advanced' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'observation' => ['string', 'max:255'],
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ];
    }
}
