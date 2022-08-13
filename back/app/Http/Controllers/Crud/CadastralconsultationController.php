<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;


use App\Http\Requests\Crud\CadastralconsultationRequest;
use App\Models\Cadastralconsultation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CadastralconsultationController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:Cadastralconsultation_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:Cadastralconsultation_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:Cadastralconsultation_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:Cadastralconsultation_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cadastralconsultations = Cadastralconsultation::latest()->get();

        return response(['data' => $cadastralconsultations], 200);
    }

    public function store(CadastralconsultationRequest $request)
    {
        DB::delete("DELETE FROM cadastralconsultations");

        $cadastraux = $request->all();
        $cadastraux_records = [];

        foreach ($cadastraux as $cadast) {
            if (!empty($cadast)) {
                $cadastralconsultation = new Cadastralconsultation();
                $cadastralconsultation->REQ_TIT = $cadast['REQ_TIT'];
                $cadastralconsultation->NUM = isset($cadast['NUM']) ? $cadast['NUM'] : null;
                $cadastralconsultation->CLEF = isset($cadast['CLEF']) ? $cadast['CLEF'] : null;
                $cadastralconsultation->CONSISTANCE = isset($cadast['CONSISTANCE']) ? $cadast['CONSISTANCE'] : null;
                $cadastralconsultation->COMMUNE = isset($cadast['COMMUNE']) ? $cadast['COMMUNE'] : null;
                $cadastralconsultation->STATUT = isset($cadast['STATUT']) ? $cadast['STATUT'] : null;
                $cadastralconsultation->MAPPE = isset($cadast['MAPPE']) ? $cadast['MAPPE'] : null;
                $cadastralconsultation->PTE_DITE = isset($cadast['PTE_DITE']) ? $cadast['PTE_DITE'] : null;
                $cadastralconsultation->SITUATION = isset($cadast['SITUATION']) ? $cadast['SITUATION'] : null;
                $cadastralconsultation->CONT_ARR = isset($cadast['CONT_ARR']) ? $cadast['CONT_ARR'] : null;
                $cadastralconsultation->DATE_ARCHIVE = isset($cadast['DATE_ARCHIVE']) ? date('Y-m-d', strtotime($cadast['DATE_ARCHIVE'])) : null;
                $cadastralconsultation->BON = isset($cadast['BON']) ? $cadast['BON'] : null;
                $cadastralconsultation->CARNET = isset($cadast['CARNET']) ? $cadast['CARNET'] : null;
                $cadastralconsultation->DATE_DEPOT = isset($cadast['DATE_DEPOT']) ? date('Y-m-d', strtotime($cadast['DATE_DEPOT'])) : null;
                $cadastralconsultation->NUM_DEPOT = isset($cadast['NUM_DEPOT']) ? $cadast['NUM_DEPOT'] : null;
                $cadastralconsultation->BORNEUR = isset($cadast['BORNEUR']) ? $cadast['BORNEUR'] : null;
                $cadastralconsultation->RESULTAT_BORNAGE = isset($cadast['RESULTAT_BORNAGE']) ? $cadast['RESULTAT_BORNAGE'] : null;
                $cadastralconsultation->DATE_BORNAGE = isset($cadast['DATE_BORNAGE']) ? date('Y-m-d', strtotime($cadast['DATE_BORNAGE'])) : null;
                $cadastralconsultation->DATE_ARRIVEE = isset($cadast['DATE_ARRIVEE']) ? date('Y-m-d', strtotime($cadast['DATE_ARRIVEE'])) : null;
                $cadastralconsultation->Y = isset($cadast['Y']) ? $cadast['Y'] : null;
                $cadastralconsultation->X = isset($cadast['X']) ? $cadast['X'] : null;
                $cadastralconsultation->REQ_MERE = isset($cadast['REQ_MERE']) ? $cadast['REQ_MERE'] : null;
                $cadastralconsultation->TITRE_MERE = isset($cadast['TITRE_MERE']) ? $cadast['TITRE_MERE'] : null;
                $cadastralconsultation->GENRE_OP = isset($cadast['GENRE_OP']) ? $cadast['GENRE_OP'] : null;
                $cadastralconsultation->INDICE = isset($cadast['INDICE']) ? $cadast['INDICE'] : null;
                $cadastralconsultation->save();
                $cadastraux_records[] = $cadastralconsultation;
            }
        };

        return response(['data' => $cadastraux_records], 201);

    }

    public function show($id)
    {
        $cadastralconsultation = Cadastralconsultation::findOrFail($id);

        return response(['data', $cadastralconsultation], 200);
    }

    public function update(CadastralconsultationRequest $request, $id)
    {
        $cadastralconsultation = Cadastralconsultation::findOrFail($id);
        $cadastralconsultation->update($request->all());

        return response(['data' => $cadastralconsultation], 200);
    }

    public function destroy($id)
    {
        Cadastralconsultation::destroy($id);

        return response(['data' => null], 204);
    }
}
