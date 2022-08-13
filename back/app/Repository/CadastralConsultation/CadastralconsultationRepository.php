<?php

namespace App\Repository\CadastralConsultation;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Cadastralconsultation;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CadastralConsultationRepository implements ICadastralConsultationRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation;
    }

    public function index($request)
    {
        try{
            return DB::table('affaire_natures')
                ->where('organisation_id','=',$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);

        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        try {
            return Cadastralconsultation::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit(Cadastralconsultation $prevElem,$data){
         // TODO: Implement edit() method.
         try {
            $prevElem->update($data->all());
            $subject = LogsEnumConst::Update . LogsEnumConst::Cadastral .$data['REQ_TIT'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
            return $prevElem;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }

    public function store($data){
        try {

        DB::delete("DELETE FROM cadastralconsultations");
        $cadastraux = $data->all();
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
                $cadastralconsultation->organisation_id = $this->organisation_id;
                $cadastralconsultation->Y = isset($cadast['Y']) ? $cadast['Y'] : null;
                $cadastralconsultation->X = isset($cadast['X']) ? $cadast['X'] : null;
                $cadastralconsultation->REQ_MERE = isset($cadast['REQ_MERE']) ? $cadast['REQ_MERE'] : null;
                $cadastralconsultation->TITRE_MERE = isset($cadast['TITRE_MERE']) ? $cadast['TITRE_MERE'] : null;
                $cadastralconsultation->GENRE_OP = isset($cadast['GENRE_OP']) ? $cadast['GENRE_OP'] : null;
                $cadastralconsultation->INDICE = isset($cadast['INDICE']) ? $cadast['INDICE'] : null;
                $cadastralconsultation->save();
            }
        };
        return $data;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function delete($id){
        Cadastralconsultation::destroy($id);
    }


}
