<?php


namespace App\Services\Charge;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\Charge\IChargeRpository;
use App\Services\Charge\IChargeService;

class ChargeService implements IChargeService
{

    private $iChargeRpository;
    public function __construct(IChargeRpository $iChargeRpository)
    {
        $this->iChargeRpository=$iChargeRpository;
    }

    public function index($request)
    {
        return $this->iChargeRpository->index($request);
    }
    public function store($request)
    {
        $res= $this->iChargeRpository->store($request);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Charge . $request['num_quit'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $res;
    }
    public function show($id)
    {
        return $this->iChargeRpository->show($id);
    }
    public function update($id,$data)
    {
        $perElem=$this->show($id);
        if($perElem){
            $subject = LogsEnumConst::Update . LogsEnumConst::Charge . $data['num_quit'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
            return $this->iChargeRpository->update($perElem,$data);
        }
        return null;
    }
    public function destroy($request)
    {
        $res=$this->iChargeRpository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Charge . $request['num_quit'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
