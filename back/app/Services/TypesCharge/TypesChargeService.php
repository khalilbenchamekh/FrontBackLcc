<?php

namespace App\Services\TypesCharge;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\TypesCharge\ITypesChargeRepository;

class TypesChargeService implements ITypesChargeService
{
    private $iTypesChargeRepository;
    public function __construct(ITypesChargeRepository $iTypesChargeRepository)
    {
        $this->iTypesChargeRepository=$iTypesChargeRepository;
    }
    public function save($request)
    {
        $typesCharge=$this->iTypesChargeRepository->save($request);
        if(!is_null($typesCharge) ){
            $subject = LogsEnumConst::Add . LogsEnumConst::TypesChange. $request->input('name');
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $typesCharge;
    }
    public function index($request)
    {
        return $this->iTypesChargeRepository->index($request);
    }
    public function show($id)
    {
        return $this->iTypesChargeRepository->show($id);
    }
    public function update($id,$request)
    {
        $typesCharge= $this->show($id);
        if(!empty($typesCharge)){
            $newTypesCharge= $this->iTypesChargeRepository->update($typesCharge,$request->all());
            if(!is_null($newTypesCharge) ){
                $subject = LogsEnumConst::Update . LogsEnumConst::TypesChange. $request->input('name');
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            }
            return $newTypesCharge;
        }
        return null;
    }
    public function destroy($request)
    {
        $model = $this->show($request->id);
        if(is_null($model)){
            return null;
        }
        $res= $this->iTypesChargeRepository->destroy($model);
        if($res === false){
            return null;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::TypesChange . $request->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $model;
        }
    }
}
