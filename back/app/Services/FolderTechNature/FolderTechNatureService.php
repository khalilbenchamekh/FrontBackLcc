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
    private function checkByName($id,$name):bool
    {
        $folderTechNature= $this->iFolderTechNatureRepository->getFolerTechNatureByName($id,$name);
        if($folderTechNature instanceof FolderTechNature){
            return true;
        }
        return false;
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
                    $affairenature=$this->iFolderTechNatureRepository->save($folderTechNature);
                    $folderTechNature_records[] = $affairenature;
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
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechNature . $name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $folderTechNature;
        }
        return null;
    }
    public function index($request)
    {
        return $this->iFolderTechNatureRepository->index($request);
    }
    public function show($id)
    {
        return $this->iFolderTechNatureRepository->show($id);
    }
    public function update($id,$request)
    {$isExest=$this->checkByName($id,$request->input('Name'));

        if($isExest === false){
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
        }elseif($isExest === true){
            return true;
        }
        return null;
    }
    public function destroy($id)
    {
        return $this->iFolderTechNatureRepository->destroy($id);
    }
}
