<?php

namespace App\Services\Client;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\Client\IClientRepository;
use App\Helpers\LogActivity;

class ClientService implements IClientService
{

    private $iClientRepository;
    public function __construct(IClientRepository $iClientRepository)
    {
        $this->iClientRepository=$iClientRepository;
    }

    public function index($request,$order=null)
    {
        return $this->iClientRepository->index($request,$order);
    }
    public function storeBusiness($data,$bus)
    {
        $res =$this->iClientRepository->storeBusiness($data,$bus);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Business . $res->ICE;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function business($data)
    {
        return $this->iClientRepository->business($data);
    }
    public function storeParticular($data,$par)
    {
        $res = $this->iClientRepository->storeParticular($data,$par);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Particular . $res->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function newParticular($data)
    {
        return $this->iClientRepository->newParticular($data);
    }
    public function store($data)
    {
        $res =  $this->iClientRepository->store($data);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Client . $res->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function get($id)
    {
        return $this->iClientRepository->get($id);
    }
    public function edit($perClient,$data)
    {
        return $this->iClientRepository->edit($perClient,$data);
    }
    public function editBusiness($data,$id)
    {
        $bus =$this->iClientRepository->getBusinessById($data->input('id_mem'));
        if(!is_null($bus)){
             $this->iClientRepository->editBusiness($data,$bus);
             $client = $this->get($id);
             if(!is_null($client)){
               $res = $this->edit($client,$data);
               if(!is_null($res)){
                $subject = LogsEnumConst::Update . LogsEnumConst::Client . $res->name;
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
                }
                return $res;
            }
        }
        return null;
    }
    public function delete($request)
    {
        $res = $this->iClientRepository->delete($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Client . $request['ICE'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
