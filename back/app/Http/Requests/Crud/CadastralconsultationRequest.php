<?php

namespace App\Http\Requests\Crud;
use Illuminate\Foundation\Http\FormRequest;

class CadastralconsultationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '*.REQ_TIT' => 'required|size:1',
            '*.NUM' => 'nullable|integer',
            '*.INDICE' => 'nullable|integer',
            '*.GENRE_OP' => 'nullable|string|max:255',
            '*.TITRE_MERE' => 'nullable|string|max:255',
            '*.REQ_MERE' => 'nullable|string|max:255',
            '*.X' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            '*.Y' => 'nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            '*.DATE_ARRIVEE' => 'nullable|',
            '*.DATE_BORNAGE' => 'nullable|',
            '*.RESULTAT_BORNAGE' => 'nullable|string|max:255',
            '*.BORNEUR' => 'nullable|string|max:255',
            '*.NUM_DEPOT' => 'nullable|string|max:255',
            '*.DATE_DEPOT' => 'nullable|',
            '*.CARNET' => 'nullable|string|max:255',
            '*.BON' => 'nullable|string|max:255',
            '*.DATE_DELIVRANCE' => 'nullable|',
            '*.NBRE_FRACTION' => 'nullable|integer',
            '*.PRIVE' => 'nullable|string|max:255',
            '*.OBSERVATIONS' => 'nullable|string|max:255',
            '*.DATE_ARCHIVE' => 'nullable',
            '*.CONT_ARR' => 'nullable|integer',
            '*.SITUATION' => 'nullable|string|max:255',
            '*.PTE_DITE' => 'nullable|string|max:255',
            '*.MAPPE' => 'nullable|string|max:255',
            '*.STATUT' => 'nullable|string|max:255',
            '*.COMMUNE' => 'nullable|string|max:255',
            '*.CONSISTANCE' => 'nullable|string|max:255',
            '*.CLEF' => 'nullable|string|max:255',
        ];
    }
}
