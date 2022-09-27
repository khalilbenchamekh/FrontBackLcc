<?php

namespace App\Services\Fees;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Resources\MemberShipType;
use App\Models\Affaire;
use App\Models\BusinessManagement;
use App\Models\Fees;
use App\Models\File as FeesFile;
use App\Repository\Fees\IFeesRepository;
use App\Services\Affaire\IAffaireService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Support\Facades\Auth;

class FeesService implements IFeesService
{

    private $iFeesRepository;
    private $iSaveFileService;
    private $iAffaireService;
    public function __construct(
        IFeesRepository $iFeesRepository,
        ISaveFileService $iSaveFileService,
        IAffaireService $iAffaireService
        )
    {
        $this->iFeesRepository=$iFeesRepository;
        $this->iSaveFileService=$iSaveFileService;
        $this->iAffaireService=$iAffaireService;
    }


    public function getFolderTechFees($request)
    {
        return $this->iFeesRepository->getFolderTechFees($request);
    }
    public function getBusinessFees($request)
    {
        return $this->iFeesRepository->getBusinessFees($request);
    }

    public function index($request)
    {
        return $this->iFeesRepository->index($request);
    }

    public function saveBusinessFees($request)
    {
        $id = $request->input('id');
        $busines_mang =$this->businessManagement($id,"Affaire");
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang[0]->id;
            $fees=$this->iFeesRepository->saveBusinessFees($busines_mang,$request);
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
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessFees. $request['id'];
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
        $busines_mang =$this->businessManagement($id,MemberShipType::folderTech);
        $size=count($busines_mang);
        if($size>0){
            $busines_mang_id = $busines_mang[0]->id;
            $fees=$this->iFeesRepository->saveFolderTechFees($busines_mang,$request);
            $business = $this->iAffaireService->show($id);
            if($request->hasfile('filenames') && $business instanceof Affaire){
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

            if(!is_null($fees)){
                $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechFees. $id;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $fees;
        }else{
            return $busines_mang;
        }
    }
    public function show()
    {

    }
    public function updateBusinessFees($request,$index)
    {

        $id = $request->input('id');
        $busines_mang =$this->businessManagement($id,MemberShipType::business);
        dd($busines_mang);
        $size=count($busines_mang);
        if($size >0){
            $busines_mang_id = $busines_mang->id;
            $fees=$this->iFeesRepository->show($index);
            if($fees instanceof Fees){
                $update_fees=$this->iFeesRepository->updateBusinessFees($fees,$request,$busines_mang_id);
                $business = $this->iAffaireService->show($id);
                if($request->hasfile('filenames') && $business instanceof Affaire){
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
                    $subject = LogsEnumConst::Update . LogsEnumConst::BusinessFees. $id;
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $request);
                }
                return $update_fees;
            }else{
                return $busines_mang;
            }
        }else{
            return $busines_mang;
        }
    }
    public function destroy()
    {

    }
    public function updateFolderTechFees($request,$index)
    {
        $id = $request->input('id');
        $busines_mang =$this->businessManagement($id,MemberShipType::folderTech);
        $size=count($busines_mang);
        if($size>0){
            $busines_mang_id = $busines_mang->id;
            $fees=$this->iFeesRepository->show($index);
            if($fees instanceof Fees){
                $update_fees=$this->iFeesRepository->updateFolderTechFees($fees,$request,$busines_mang_id);
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
                    $subject = LogsEnumConst::Update . LogsEnumConst::FolderTechFees. $request['id'];
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $request);
                }
                return $update_fees;
            }else{
                return $busines_mang;
            }
        }
    }

    private function businessManagement($id,$relation)
    {
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)
        ->where("organisation_id","=",3)
        ->where('membership_type', 'like', '%' . $relation)
        ->get();
        return $busines_mang;
    }
}
