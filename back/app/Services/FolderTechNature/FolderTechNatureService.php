<?php


namespace App\Services\FolderTechNature;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\FolderTechNature;
use App\Repository\FolderTechNature\IFolderTechNatureRepository;
use Illuminate\Http\Request;

class FolderTechNatureService implements IFolderTechNatureService
{
    private $iFolderTechNatureRepository;
    public function __construct(IFolderTechNatureRepository $iFolderTechNatureRepository)
    {
        $this->iFolderTechNatureRepository =$iFolderTechNatureRepository;
    }

    public function storeMany(Request $request)
    {
            $data=$request->all();
            $folderTechNatures = $data["folderTechNature"];
            $folderTechNature_records = [];
            foreach($folderTechNatures as $folderTechNature)
            {
                if(! empty($folderTechNature))
                {
                    $res=$this->iFolderTechNatureRepository->save($folderTechNature);
                    if(!is_null($res)){
                        $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechNature . $res->Abr_v;
                        $logs = new LogActivity();
                        $logs->addToLog($subject, $request);
                        $folderTechNature_records[] = $res;
                    }
                }
            }
            return $folderTechNature_records;
    }
    public function save($request)
    {
        $name= $request->input('Name');
        $abr_v=$request->input('Abr_v');
        $abr_v=empty($abr_v) ? substr($name,0,3) : $abr_v;
        $folderTechNature=$this->iFolderTechNatureRepository->save($request->all());
        if(!is_null($folderTechNature)){
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechNature . $abr_v;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $folderTechNature;
        }
        return null;
    }
    public function index($request,$order=null)
    {
        return $this->iFolderTechNatureRepository->index($request,$order);
    }
    public function show($id)
    {
        return $this->iFolderTechNatureRepository->show($id);
    }
    public function update($id,$request)
    {
        $folderTechNature= $this->iFolderTechNatureRepository->getFolerTechNatureByName($id,$request->input('Name'));
            $folderTechNature=$this->show($id);
            if($folderTechNature instanceof FolderTechNature){
                $name= $request->input('Name');
                $abr_v= $request->input('Abr_v');
                $abr_v=empty($abr_v) ? substr($name,0,3) : $abr_v;
                $folderTechNature=$this->iFolderTechNatureRepository->update($folderTechNature,$request->all());
                if(!is_null($folderTechNature)){
                    $subject = LogsEnumConst::Update . LogsEnumConst::FolderTechNature . $abr_v;
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $request);
                    return $folderTechNature;
                }
            }
        return null;
    }
    public function destroy($request)
    {
        $res = $this->iFolderTechNatureRepository->destroy($request->id);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::FolderTechNature . $request->Abr_v;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $res;
    }
}
