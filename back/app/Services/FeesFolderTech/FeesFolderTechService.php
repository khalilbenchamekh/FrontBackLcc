<?php


namespace App\Services\FeesFolderTech;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\FeesFolderTech\IFeesFolderTechRepository;

class FeesFolderTechService implements IFeesFolderTechService
{
    private $iFeesFolderTechRepository;
    public function __construct(IFeesFolderTechRepository $iFeesFolderTechRepository)
    {
        $this->iFeesFolderTechRepository=$iFeesFolderTechRepository;
    }

    public function save($request)
    {

        $feesFolderTech=$this->iFeesFolderTechRepository->save($request->all());
        if(!is_null($feesFolderTech)){
            $subject = LogsEnumConst::Add . LogsEnumConst::FeesFolderTech . $request->input('id');
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $feesFolderTech;
    }
    public function index($request)
    {
        return $this->iFeesFolderTechRepository->index($request);
    }
    public function update($request,$id)
    {
        $feesFolderTech=$this->show($id);
        if(!empty($feesFolderTech)){
            $newFeesFolderTech= $this->iFeesFolderTechRepository->update($feesFolderTech,$request->all());
            if(!is_null($newFeesFolderTech) ){
                $subject = LogsEnumConst::Update . LogsEnumConst::FeesFolderTech. $request->input('id');
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $newFeesFolderTech;
        }
        return null;
    }
    public function show($id)
    {
        return $this->iFeesFolderTechRepository->show($id);
    }
    public function destroy($id)
    {
        return $this->iFeesFolderTechRepository->destroy($id);
    }
}
