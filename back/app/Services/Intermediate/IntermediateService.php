<?php


namespace App\Services\Intermediate;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Intermediate;
use App\Repository\Intermediate\IIntermediateRepository;


class IntermediateService implements IIntermediateService
{
    private $iIntermediateRepository;
    public function __construct(IIntermediateRepository $iIntermediateRepository)
    {
        $this->iIntermediateRepository=$iIntermediateRepository;
    }
    public function save($request)
    {
        $intermediate=$this->iIntermediateRepository->save($request->all());
        if(!is_null($intermediate)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Intermediate . $intermediate->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $intermediate;
        }
        return null;
    }
    public function index($request,$order=null)
    {
        return $this->iIntermediateRepository->index($request,$order);
    }
    public function show($id)
    {
        return $this->iIntermediateRepository->show($id);
    }
    public function update($id,$request)
    {
        $perIntermediate=$this->show($id);
        if($perIntermediate instanceof Intermediate){
            $intermediate=$this->iIntermediateRepository->update($perIntermediate,$request);
            if(!is_null($intermediate)){
                $subject = LogsEnumConst::Update . LogsEnumConst::Intermediate . $intermediate->name;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                return $intermediate;
            }
        }
        return null;

    }
    public function destroy($request)
    {
        $res= $this->iIntermediateRepository->destroy($request->id);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Intermediate . $request->Name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $res;
    }
}
