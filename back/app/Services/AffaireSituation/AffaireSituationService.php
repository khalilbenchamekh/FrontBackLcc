<?php

namespace App\Services\AffaireSituation;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\AffaireSituation\IAffaireSituationRepository;

class AffaireSituationService implements IAffaireSituationService
{
    private $affaireSituationRepository;
    public function __construct(IAffaireSituationRepository $affaireSituationRepository)
    {
        $this->affaireSituationRepository=$affaireSituationRepository;
    }

    public function index($request)
    {
        // TODO: Implement index() method.
        return $this->affaireSituationRepository->index($request);
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->affaireSituationRepository->get($id);
    }

    public function edit($perAffaireSituation, $data)
    {
        // TODO: Implement edit() method.
        $res = $this->affaireSituationRepository->edit($perAffaireSituation, $data);
        if(!is_null($res)){
            $subject = LogsEnumConst::Update . LogsEnumConst::BusinessSituation . $data['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return null;
    }

    public function delete($request)
    {
        $res = $this->affaireSituationRepository->delete($request);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::BusinessSituation . $request['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->affaireSituationRepository->store($data);
    }

    public function storeMany($data)
    {
        // TODO: Implement storeMany() method.
        return $this->affaireSituationRepository->storeMany($data);
    }
}
