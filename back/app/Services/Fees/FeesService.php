<?php

namespace App\Services\Fees;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Resources\MemberShipType;
use App\Models\Fees;
use App\Repository\BusinessManagement\IBusinessManagementRespositry;
use App\Repository\Fees\IFeesRepository;
class FeesService implements IFeesService
{

    private $iFeesRepository;
    private $iBusinessManagementRespositry;
    public function __construct(
        IFeesRepository $iFeesRepository,
        IBusinessManagementRespositry $iBusinessManagementRespositry
        )
    {
        $this->iFeesRepository=$iFeesRepository;
        $this->iBusinessManagementRespositry=$iBusinessManagementRespositry;
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
        $busines_mang =$this->iBusinessManagementRespositry->businessManagement($id,MemberShipType::business);
        if(!is_null($busines_mang)){
            $fees=$this->iFeesRepository->saveBusinessFees($busines_mang,$request);
            if(!is_null($fees) ){
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessFees. $fees->ICE;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $fees;
        }
        return null;
    }
    public function saveGreatConstructionSitesFees($request,$id= null)
    {
        $id = is_null($id) ? $request->input('id') : $id;
        $busines_mang =$this->iBusinessManagementRespositry->businessManagement($id,MemberShipType::greatConstructionSites);
        if(!is_null($busines_mang)){
            $fees=$this->iFeesRepository->saveBusinessFees($busines_mang,$request);
            if(!is_null($fees) ){
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessFees. $fees->ICE;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $fees;
        }
        return null;
    }
    public function saveFolderTechFees($request)
    {
        $id = $request->input('id');
        $busines_mang =$this->iBusinessManagementRespositry->businessManagement($id,MemberShipType::folderTech);
        if(!is_null($busines_mang)){
            $fees=$this->iFeesRepository->saveFolderTechFees($busines_mang,$request);
            if(!is_null($fees) ){
                $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechFees. $fees->ICE;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $fees;
        }
        return null;
    }
    public function show()
    {

    }
    public function updateBusinessFees($request,$index)
    {
        $id = $request->input('id');
        $busines_mang =$this->iBusinessManagementRespositry->businessManagement($id,MemberShipType::business);
        if(!is_null($busines_mang)){
            $fees=$this->iFeesRepository->show($index);
            if(!is_null($fees)){
                $update_fees=$this->iFeesRepository->updateBusinessFees($fees,$request,$busines_mang->id);
                if(!is_null($update_fees) ){
                    $subject = LogsEnumConst::Update . LogsEnumConst::BusinessFees. $fees->ICE;
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $request);
                }
                return $update_fees;
            }
        }
        return null;
    }
    public function destroy()
    {

    }
    public function updateFolderTechFees($request,$index)
    {
        $id = $request->input('id');
        $busines_mang =$this->iBusinessManagementRespositry->businessManagement($id,MemberShipType::folderTech);
        if(!is_null($busines_mang)){
            $busines_mang_id = $busines_mang->id;
            $fees=$this->iFeesRepository->show($index);
            if($fees instanceof Fees){
                $update_fees=$this->iFeesRepository->updateFolderTechFees($fees,$request,$busines_mang_id);
                if(!is_null($update_fees) ){
                    $subject = LogsEnumConst::Update . LogsEnumConst::BusinessFees. $fees->ICE;
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $request);
                }
                return $update_fees;
            }
        return null;
        }
    }

}
