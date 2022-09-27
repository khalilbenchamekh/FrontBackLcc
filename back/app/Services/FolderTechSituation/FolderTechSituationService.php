<?php


namespace App\Services\FolderTechSituation;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\FolderTechSituation;
use App\Repository\FolderTechSituation\IFolderTechSituationRepository;
use Illuminate\Http\Request;

class FolderTechSituationService implements IFolderTechSituationService
{
    private $iFolderTechSituationRepository;
    public function __construct(IFolderTechSituationRepository $iFolderTechSituationRepository)
    {
        $this->iFolderTechSituationRepository=$iFolderTechSituationRepository;
    }

    public function storeMany(Request $request)
    {
        $data=$request->all();
        $foldertechsituations=$data['foldertechsituation'];

        $foldertechsituations_records=[];

        foreach ($foldertechsituations as $foldertechsituation)
        {
            if(! empty($foldertechsituation)){
                $saveFoldertechsituations=$this->iFolderTechSituationRepository->save($foldertechsituation);
                $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechSituation . $foldertechsituation['Name'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                $affaire_records[] = $foldertechsituation;
                $foldertechsituations_records[]=$saveFoldertechsituations;
            }
        }

        return $foldertechsituations_records;
    }

    public function save($request)
    {
        $folderTechSituation=$this->iFolderTechSituationRepository->save($request->all());
        if(!is_null($folderTechSituation)){
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechSituation . $folderTechSituation->Name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $folderTechSituation;
        }
        return null;
    }
    public function index($request)
    {
        return $this->iFolderTechSituationRepository->index($request);
    }
    public function show($id)
    {
        return $this->iFolderTechSituationRepository->show($id);
    }
    public function update($id,$request)
    {
        $perFolderTechSituation=$this->show($id);
        if($perFolderTechSituation instanceof FolderTechSituation){
            $folderTechSituation=$this->iFolderTechSituationRepository->update($perFolderTechSituation,$request);
            if(!is_null($folderTechSituation)){
                $subject = LogsEnumConst::Update . LogsEnumConst::FolderTechSituation . $folderTechSituation->Name;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                return $folderTechSituation;
            }
        }
        return null;
    }
    public function destroy($id)
    {
        $folderTechSituation=$this->show($id);
        if($folderTechSituation instanceof FolderTechSituation){
            return $this->iFolderTechSituationRepository->destroy($folderTechSituation);
        }
        return null;

    }

}
