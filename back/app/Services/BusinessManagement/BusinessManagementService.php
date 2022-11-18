<?php

namespace App\Services\BusinessManagement;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\BusinessManagement\IBusinessManagementRespositry;

class BusinessManagementService  implements IBusinessManagementService
{
    private $iBusinessManagementRespositry;
    public function __construct(IBusinessManagementRespositry $iBusinessManagementRespositry)
    {
        $this->iBusinessManagementRespositry=$iBusinessManagementRespositry;
    }

    public function index($request)
    {
        return $this->iBusinessManagementRespositry->index($request);
    }
    public function store($data,$affaire = null)
    {
        $res=$this->iBusinessManagementRespositry->store($data,$affaire);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::BusinessManagement . $data['id'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return $res;
    }
    public function get($id)
    {
        return $this->iBusinessManagementRespositry->show($id);
    }
    public function edit($id,$data)
    {
        $perElem=$this->get($id);
        if($perElem){
            $res = $this->iBusinessManagementRespositry->update($perElem,$data);
            if(!is_null($res)){
                $subject = LogsEnumConst::Update . LogsEnumConst::BusinessManagement . $data['id'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
            }
            return $res;
        }
        return null;
    }
    public function delete($request)
    {
        $res= $this->iBusinessManagementRespositry->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::BusinessManagement . $request['id'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
