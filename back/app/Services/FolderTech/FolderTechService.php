<?php


namespace App\Services\FolderTech;

use Carbon\Carbon;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\FolderTech;
use App\Repository\FolderTech\IFolderTechRepository;

class FolderTechService implements IFolderTechService
{
    private $iFolderTechRepository;
    public function __construct(IFolderTechRepository $iFolderTechRepository)
    {
        $this->iFolderTechRepository=$iFolderTechRepository;
    }
    public function save($request)
    {
        $res= $this->iFolderTechRepository->save($request);
        if(!is_null($res) ){
            $resBu = $this->saveBusinessManagement($request,$res);
            $resMission = $this->saveMission($request,$res);
            if(!is_null($resBu) && !is_null($resMission) ){
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTech. $res->REF;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            }
        }
        return $res;
    }
    public function getFolderTechBetween($from ,$to)
    {
        
        return $this->iFolderTechRepository->getFolderTechBetween($from,$to);
    }
    public function saveBusinessManagement($request,$affaire)
    {
        $res= $this->iFolderTechRepository->saveBusinessManagement($request,$affaire);
        return $res;
    } public function saveMission($request,$affaire)
    {
        $res= $this->iFolderTechRepository->saveMission($request,$affaire);
        return $res;
    }
    public function index($request)
    {
        return $this->iFolderTechRepository->index($request);
    }
    public function show($id)
    {
        return $this->iFolderTechRepository->show($id);
    }
    public function update($id,$request)
    {
        $folderTech=$this->show($id);
        if($folderTech instanceof FolderTech){
            $folderTechUpdated= $this->iFolderTechRepository->update($folderTech,$request);
            if(!is_null($folderTechUpdated) ){
                $subject = LogsEnumConst::Update . LogsEnumConst::FolderTech. $folderTechUpdated->REF;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $folderTechUpdated;
        }
        return null;
    }
    public function delete($request)
    {
        $res = $this->iFolderTechRepository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::FolderTech . $request['REF'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }

    public function getFolderTech($request)
    {
        return $this->iFolderTechRepository->getFolderTech($request);
    }

}
