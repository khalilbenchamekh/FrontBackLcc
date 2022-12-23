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
        $this->iClientRepository = $iClientRepository;
    }

    public function index($request, $order = null)
    {
        return $this->iClientRepository->index($request, $order);
    }
    public function storeBusiness($data, $bus)
    {
        $res = $this->iClientRepository->storeBusiness($data->all(), $bus);
        if (!is_null($res)) {
            $subject = LogsEnumConst::Add . LogsEnumConst::Business . $res->ICE;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function business($data)
    {
        $res =  $this->iClientRepository->business($data);
        if (!is_null($res)) {
            $subject = LogsEnumConst::Add . LogsEnumConst::Business . $res->ICE;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function storeParticular($data, $par)
    {
        $res = $this->iClientRepository->storeParticular($data, $par);
        if (!is_null($res)) {
            $subject = LogsEnumConst::Add . LogsEnumConst::Particular . $res->Function;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function newParticular($data)
    {
        $res = $this->iClientRepository->newParticular($data);
        if (!is_null($res)) {
            $subject = LogsEnumConst::Add . LogsEnumConst::Particular . $res->Function;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function store($data)
    {
        $res =  $this->iClientRepository->store($data->all());
        if (!is_null($res)) {
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
    public function edit($perClient, $data)
    {
        return $this->iClientRepository->edit($perClient, $data);
    }
    public function editBusiness($data, $id)
    {
        $client = $this->get($id);
        if (!is_null($client)) {
            $bus = $this->iClientRepository->getBusinessById($data->input('id_mem'));
            if (!is_null($bus)) {
                $this->iClientRepository->editBusiness($data, $bus);
                $res = $this->edit($client, $data->all());
                if (!is_null($res)) {
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
        $model = $this->get($request->id);
        if(is_null($model)){
            return null;
        }
        $res = $this->iClientRepository->delete($model);
        if($res === false){
            return null;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Client .$request['ICE'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $model;
        }
    }
}
