<?php

namespace App\Repository\AffaireSituation;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\AffaireSituation;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AffaireSituationRepository implements IAffaireSituationRepository
{
    use LogTrait;
    private $organisation_id;
    private $current_user;
    public function __construct()
    {
        $this->organisation_id = Auth::user()->organisation_id;
        $this->current_user=Auth::user()->id;
    }
    public function index($request,$order=null)
    {
        // TODO: Implement index() method.
        try {
            $affaireSituation= AffaireSituation::where("organisation_id","=",$this->organisation_id)
            ->when(!is_null($order),function ($query){
                return $query->latest();
            })
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $affaireSituation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        try {
           return AffaireSituation::where("organisation_id",'=',$this->organisation_id)
           ->find($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($perAffaireSituation, $data)
    {
        // TODO: Implement edit() method.
        try {
            $saveData= $data->all();
            $perAffaireSituation->Name=$saveData['Name'];
            $perAffaireSituation->orderChr=$saveData['orderChr'];
            $perAffaireSituation->save();
            return $perAffaireSituation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function delete($data)
    {
        // TODO: Implement delete() method.
        try {
            $model= AffaireSituation::where("organisation_id",'=',$this->organisation_id)->find($data['id']);
            $deleted = $model;
            $deleted->delete();
            return $model;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        try {
            $affaireSituation = new AffaireSituation();
            $affaireSituation->organisation_id=$this->organisation_id;
            $affaireSituation->orderChr=$data['orderChr'];
            $affaireSituation->Name=$data['Name'];
            $affaireSituation->created_at=Carbon::now();
            $affaireSituation->save();
            return $affaireSituation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function storeMany($data)
    {
        // TODO: Implement storeMany() method.
        try {
            $dataToSave = $data->all()['affaireSituations'];
            foreach ($dataToSave as $item){
                $affaireSituation= new AffaireSituation();
                $affaireSituation->organisation_id=$this->organisation_id;
                $affaireSituation->Name=$item['Name'];
                $affaireSituation->orderChr=$item['orderChr'];
                $affaireSituation->save();
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessSituation . $item['Name'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
            }
            return $dataToSave;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

}
