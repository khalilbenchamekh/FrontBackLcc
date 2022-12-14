<?php


namespace App\Services\Affaire;

use Carbon\Carbon;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\Affaire\IAffaireRepository;
use App\Services\BusinessManagement\IBusinessManagementService;
use App\Services\Mission\IMissionService;

class AffaireService implements IAffaireService{

    private $iAffaireRepository;
    private $businessManagementService;
    private $missionService;
    public function __construct(IAffaireRepository $iAffaireRepository,
    IBusinessManagementService $businessManagementService,
    IMissionService $missionService)
    {
        $this->iAffaireRepository=$iAffaireRepository;
        $this->businessManagementService = $businessManagementService;
        $this->missionService = $missionService;
    }
    public function getBusiness($request)
    {
        return $this->iAffaireRepository->getBusiness($request);
    }
    public function getAffaireBetween($from ,$to)
    {
        return $this->iAffaireRepository->getAffaireBetween($from,$to);
    }

    public function save($request)
    {
        $affaire= $this->iAffaireRepository->save($request);
        if(!is_null($affaire) ){
            $resBusinessManagement=$this->businessManagementService->store($request,$affaire);
            $resMission=$this->missionService->save($request);
            $subject = LogsEnumConst::Add . LogsEnumConst::Affaire. $affaire->REF;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $affaire;
    }
    public function show($id)
    {
        return $this->iAffaireRepository->show($id);
    }
    public function index($request)
    {
        return $this->iAffaireRepository->index($request);
    }
    public function update($request,$id)
    {
        $affaire=$this->iAffaireRepository->getAffaireBy(['REF'=>$id]);
        if(!empty($affaire)){
            $newAffaire= $this->iAffaireRepository->update($affaire,$request);
            if(!is_null($newAffaire) ){
                $resBusinessManagement=$this->businessManagementService->store($request,$affaire);
                $resMission=$this->missionService->save($request);
                $subject = LogsEnumConst::Update . LogsEnumConst::Affaire. $affaire->REF;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $newAffaire;
        }
        return null;
    }
    public function destroy($request)
    {
        $res =  $this->iAffaireRepository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Affaire . $request['REF'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }

}

