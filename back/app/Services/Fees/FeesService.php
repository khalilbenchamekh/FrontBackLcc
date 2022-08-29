<?php

namespace App\Services\Fees;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Affaire;
use App\Models\BusinessManagement;
use App\Models\File as FeesFile;
use App\Repository\Fees\IFeesRepository;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Support\Facades\Auth;

class FeesService implements IFeesService
{

    private $organisation_id;
    private $iFeesRepository;
    private $iSaveFileService;
    public function __construct(
        IFeesRepository $iFeesRepository,
        ISaveFileService $iSaveFileService
        )
    {
        $this->organisation_id=Auth::User()->organisation_id;
        $this->iFeesRepository=$iFeesRepository;
        $this->iSaveFileService=$iSaveFileService;
    }

    public function index($request)
    {
        return $this->iFeesRepository->index($request);
    }
    private function businessManagement($id,$relation)
    {
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)
        ->where("organisation_id","=",$this->organisation_id)
        ->where('membership_type', 'like', '%' . $relation)
        ->get();
        return $busines_mang;
    }
    public function saveBusinessFees($request)
    {
        $id = $request->input('id');
        $busines_mang =$this->businessManagement($id,"Affaire");
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang[0]->id;
            $fees=$this->iFeesRepository->store($busines_mang,$request);
            $business = Affaire::findOrFail($id);
            if($request->hasfile('filenames')){
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
                foreach($request->file('filenames') as $file){
                    $pathName=$this->iSaveFileService->saveFile($pathToMove,$file);
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $pathName;
                    $fileModel->save();
                }
            }
            if(!is_null($fees) ){
                $subject = LogsEnumConst::Add . LogsEnumConst::Fees. $request['id'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $fees;
        }else{
            return $busines_mang;
        }

    }
    public function saveFolderTechFees($request)
    {
        $id = $request->input('id');
        $busines_mang =$this->businessManagement($id,"FolderTech");
        $size=count($busines_mang);
        if($size>0){
            $busines_mang_id = $busines_mang[0]->id;
            $fees=$this->iFeesRepository->store($busines_mang,$request);
            $business = Affaire::findOrFail($id);
        }
    }
    public function show()
    {

    }
    public function update()
    {

    }
    public function destroy()
    {

    }
}
