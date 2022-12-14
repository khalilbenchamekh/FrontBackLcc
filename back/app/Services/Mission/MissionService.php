<?php
namespace App\Services\Mission;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\Mission\IMissionRepository;

class MissionService implements IMissionService
{
    private $iMissionRepository;
    public function __construct(IMissionRepository $iMissionRepository)
    {
        $this->iMissionRepository=$iMissionRepository;
    }
    public function save($request)
    {
        $typesCharge=$this->iMissionRepository->save($request);
        if(!is_null($typesCharge)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Mission . $request->input('text');
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $typesCharge;
    }
    public function show($id)
    {
        return $this->iMissionRepository->show($id);
    }
    public function index($request)
    {
        return $this->iMissionRepository->index($request);
    } public function  getMissionOfUSer($userID)
    {
        return $this->iMissionRepository->getMissionOfUSer($userID);
    }
    public function update($request,$id)
    {
        $TypesCharge=$this->show($id);
        if(!empty($TypesCharge)){
            $newTypesCharge= $this->iMissionRepository->update($TypesCharge,$request);
            if(!is_null($newTypesCharge) ){
                $subject = LogsEnumConst::Update . LogsEnumConst::Mission. $request->input('text');
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $newTypesCharge;
        }
        return null;
    }
    public function destroy($request)
    {
        $res= $this->iMissionRepository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Intermediate . $request['text'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
