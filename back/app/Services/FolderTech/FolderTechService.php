<?php


namespace App\Services\FolderTech;

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
        $folderTech= $this->iFolderTechRepository->save($request);
        if(!is_null($folderTech) ){
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTech. $request['id'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $folderTech;
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
                $subject = LogsEnumConst::Update . LogsEnumConst::FolderTech. $request['id'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $folderTechUpdated;
        }
        return null;
    }
    public function destroy($id)
    {
        return $this->iFolderTechRepository->destroy($id);
    }
    public function getFolderTech($request)
    {
        return $this->iFolderTechRepository->getFolderTech($request);
    }

}
