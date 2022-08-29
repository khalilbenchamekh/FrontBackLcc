<?php

namespace App\Services\CadastralConsultation;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\CadastralConsultation\ICadastralConsultationRepository;
use App\Repository\Log\LogTrait;

class CadastralconsultationService implements ICadastralconsultationService
{
    use LogTrait;
    private $iCadastralConsultationRepository;
    public function __construct(ICadastralConsultationRepository $iCadastralConsultationRepository)
    {
        $this->iCadastralConsultationRepository=$iCadastralConsultationRepository;
    }
    public function index($request)
    {
        return $this->iCadastralConsultationRepository->index($request);
    }
    public function store($request)
    {
        $res=$this->iCadastralConsultationRepository->store($request);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Cadastral . $request['REQ_TIT'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $res;
    }
    public function show($id)
    {
        return $this->iCadastralConsultationRepository->get($id);
    }
    public function update($id,$request)
    {
        $prevElem=$this->show($id);
        if($prevElem){
                $subject = LogsEnumConst::Update . LogsEnumConst::Cadastral . $request['REQ_TIT'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
            return $this->iCadastralConsultationRepository->edit($prevElem,$request);
        }
        return null;
    }
    public function destroy($request)
    {
        $res= $this->iCadastralConsultationRepository->delete($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::BusinessNature . $request['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
