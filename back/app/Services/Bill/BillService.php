<?php
namespace App\Services\Bill;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Services\Organisation\IOrganisationService;
use App\Repository\Bill\IBillRepository;
use App\Helpers\LogActivity;

class BillService implements IBillService
{
    private $iOrganisationService;
    private $iBillRepository;
    public function __construct(IOrganisationService $iOrganisationService,IBillRepository $iBillRepository) {
        $this->iOrganisationService = $iOrganisationService;
        $this->iBillRepository = $iBillRepository;
    }
    public function get($ref){
        return $this->iBillRepository->get($ref);
    }
    public function store($data,$ref){
        $res = $this->iBillRepository->store($data,$ref);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Bill . $data['type'] .' '.$ref ;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return null;
    }

    public function storeBillDetail($data,$billsId){
        return $this->iBillRepository->storeBillDetail($data,$billsId);
    }
     public function update($bills,$data,$ref){
        $res = $this->iBillRepository->update($bills,$data,$ref);
        if(!is_null($res)){
            $subject = LogsEnumConst::Update . LogsEnumConst::Bill . $data['type'] .' '.$ref ;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return null;
    }

    public function generateRef($type){
        $ref = $this->iOrganisationService->getMyOrganisation()->name . '-' . $type . '-' . time();
        return $ref;
    }
}
