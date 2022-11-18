<?php

namespace App\Services\LoadTypes;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Services\LoadTypes\ILoadTypesService;
use App\Helpers\LogActivity;
use App\Repository\LoadTypes\ILoadTypesRepository;
class LoadTypesService implements ILoadTypesService
{
    public $loadTypesRepository;
    public function __construct(ILoadTypesRepository $loadTypesRepository)
    {
        $this->loadTypesRepository=$loadTypesRepository;
    }
    public function index($request)
    {
       return  $this->loadTypesRepository->index($request);
    }
    public function store($data)
    {
       $res = $this->loadTypesRepository->store($data);
       if(!is_null($res)){
        $subject = LogsEnumConst::Add . LogsEnumConst::LoadType . $res->name;
        $logs = new LogActivity();
        $logs->addToLog($subject, $data);
        return $res;
    }
    return null;
    }
    public function edit($data,$perLoadType)
    {
        $res = $this->loadTypesRepository->edit($data,$perLoadType);
        if(!is_null($res)){
            $subject = LogsEnumConst::Update . LogsEnumConst::LoadType . $res->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
            return $res;
        }
        return null;
    }
    public function delete($request)
    {
        $res= $this->loadTypesRepository->delete($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::LoadType . $request['name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
    public function get($id)
    {
        return $this->loadTypesRepository->get($id);
    }
    public function saveManyLoadTypes($data)
    {
        return $this->loadTypesRepository->saveManyLoadTypes($data);
    }
}
