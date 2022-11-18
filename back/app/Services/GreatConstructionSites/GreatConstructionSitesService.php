<?php


namespace App\Services\GreatConstructionSites;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\GreatConstructionSites\IGreatConstructionSitesRepository;

class GreatConstructionSitesService implements IGreatConstructionSitesService
{
    private $iGreatConstructionSitesRepository;
    public function __construct(IGreatConstructionSitesRepository $iGreatConstructionSitesRepository)
    {
        $this->iGreatConstructionSitesRepository = $iGreatConstructionSitesRepository;
    }

    public function dashboard($from,$to,$orderBy)
    {
        $byDateAffChoice = $this->iGreatConstructionSitesRepository->dashboard($from,$to,$orderBy);
        if(is_null($byDateAffChoice)) return null;
        $dataEn_cours = [];
        $dataTeminé = [];
        $dataEn_Attente_de_validation = [];
        $dataAnnulé = [];
        $gropBy = [];
        for ($i = 0; $i < sizeof($byDateAffChoice); $i++) {
            $item = $byDateAffChoice[$i];
            array_push($dataEn_cours, $item->En_cours);
            array_push($dataTeminé, $item->Teminé);
            array_push($dataEn_Attente_de_validation, $item->En_Attente_de_validation);
            array_push($dataAnnulé, $item->Annulé);
            array_push($gropBy, $item->$orderBy);
        }

        $series = [
            [
                "name" => "En cours",
                "data" => $dataEn_cours,
            ], [
                "name" => "Teminé",
                "data" => $dataTeminé,
            ], [
                "name" => "En Attente de validation",
                "data" => $dataEn_Attente_de_validation,
            ], [
                "name" => "Annulé",
                "data" => $dataAnnulé,
            ],

        ];
        $data = [
            "series" => $series,
            "categories" => array_unique($gropBy)
        ];
        return $data;
    }

    public function index(){
        return $this->iGreatConstructionSitesRepository->index();
    }
    public function store($request)
    {
        return $this->iGreatConstructionSitesRepository->store($request);
    }
    public function show($id)
    {
        return $this->iGreatConstructionSitesRepository->show($id);
    }
    public function storeAllocatedBrigade($request,$greatconstructionsites,$arrayToReturend)
    {
        $toAssociete = $this->iGreatConstructionSitesRepository->storeAllocatedBrigade($arrayToReturend);
        $greatconstructionsites->allocatedBrigades()->attach($toAssociete);
        if(!is_null($greatconstructionsites)){
            $subject = LogsEnumConst::Add . LogsEnumConst::GSC . $greatconstructionsites->Market_title;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $greatconstructionsites;
        }
        return null;
    }
    public function updateAllocatedBrigade($request,$greatconstructionsites,$arrayToReturend)
    {
        $toAssociete = $this->iGreatConstructionSitesRepository->storeAllocatedBrigade($arrayToReturend);
        $greatconstructionsites->allocatedBrigades()->attach($toAssociete);
        if(!is_null($greatconstructionsites)){
            $subject = LogsEnumConst::Update . LogsEnumConst::GSC . $greatconstructionsites->Market_title;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $greatconstructionsites;
        }
        return null;
    }
    public function storeBusinessManagement($ttc,$greatconstructionsites){
        return $this->iGreatConstructionSitesRepository->storeBusinessManagement($ttc,$greatconstructionsites);
    }
    public function destroy($request)
    {
        $res= $this->iGreatConstructionSitesRepository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::FolderTechSituation . $request['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
