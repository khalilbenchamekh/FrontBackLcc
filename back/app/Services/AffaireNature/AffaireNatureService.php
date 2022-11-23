<?php

namespace App\Services\AffaireNature;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Repository\AffaireNature\IAffaireNatureRepository;

class AffaireNatureService implements IAffaireNatureService
{
    private $affaireNatureRepository;
    public function __construct(IAffaireNatureRepository $affaireNatureRepository)
    {
        $this->affaireNatureRepository=$affaireNatureRepository;
    }

    public function store($request)
    {
        $res = $this->affaireNatureRepository->store($request->all());
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::BusinessNature . $request['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return $res;
    }

    public function getAllAffaireNature($request)
    {
        return $this->affaireNatureRepository->getAllAffaireNature($request);
    }

    public function get($id)
    {
        return $this->affaireNatureRepository->get($id);
    }
    public function index($request, $order = null)
    {
        return $this->affaireNatureRepository->index($request,$order);
    }

    public function edit($id, $data)
    {
        // TODO: Implement edit() method.
            $affairNature=$this->get($id);
            if($affairNature){
                $newAffaireNature=$this->affaireNatureRepository->edit($affairNature,$data->all());
                $subject = LogsEnumConst::Update . LogsEnumConst::BusinessNature . $data['Name'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
                return $newAffaireNature;
            }
            return null;
    }

    public function saveMany($data)
    {
       return  $this->affaireNatureRepository->saveMany($data->all());
    }

    public function destroy($request)
    {
        $res =  $this->affaireNatureRepository->destroy($request['id']);
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
