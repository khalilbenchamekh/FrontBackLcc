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
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation;
    }
    public function index($request)
    {
        // TODO: Implement index() method.
        try {
            return AffaireSituation::
                select()
                ->where("organisation_id","=",$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        try {
           return AffaireSituation::where("id","=",$id)
           ->where("organisation_id",'=',$this->organisation_id)
           ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($perAffaireSituation, $data)
    {
        // TODO: Implement edit() method.
        try {
            $perAffaireSituation->Name=$data['Name'];
            $perAffaireSituation->orderChr=$data['orderChr'];
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
            return AffaireSituation::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
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
            foreach ($data as $item){
                $affaireSituation= new AffaireSituation();
                $affaireSituation->organisation_id=$this->organisation_id;
                $affaireSituation->Name=$item['Name'];
                $affaireSituation->orderChr=$item['orderChr'];
                $affaireSituation->save();
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessSituation . $item['Name'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
            }
            return $data;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
