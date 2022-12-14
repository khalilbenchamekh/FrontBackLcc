<?php

namespace App\Repository\AffaireNature;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\AffaireNature;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class AffaireNatureRepository implements IAffaireNatureRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::user()->organisation_id;
    }

    public function findAffaireNatureByName($name){
        try {
            return AffaireNature::where('name', 'like', '%' . $name . '%')
            ->where('organisation_id','=',$this->organisation_id)->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($data)
    {
        try{
            $affireNature= new AffaireNature();
            $abr_v = empty($data['Abr_v']) ? substr($data['Name'], 0, 3) : $data['Abr_v'];
            $affireNature->Name=$data['Name'];
            $affireNature->Abr_v=$abr_v;
            $affireNature->organisation_id =$this->organisation_id;
            $affireNature->save();
            return $affireNature;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getAllAffaireNature($request)
    {
        try{
            return AffaireNature::where('organisation_id','=',$this->organisation_id)
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
            return AffaireNature::where("organisation_id",'=',$this->organisation_id)
                ->find($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function index($request,$order=null)
    {
        try{
            $affairenature=AffaireNature::select();
            if(!is_null($order)){
                $affairenature->latest();
            }
            $affairenature->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $affairenature;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit(AffaireNature $affairNature, $data)
    {
        // TODO: Implement edit() method.
        try {
            $abr_v = empty($data['Abr_v']) ? substr($data['Name'], 0, 3) : $data['Abr_v'];
            $affairNature->Name=$data['Name'];
            $affairNature->Abr_v=$abr_v;
            $affairNature->organisation_id=$this->organisation_id;
            $affairNature->save();
            return $affairNature;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

     public function saveMany($data)
    {
        # code...
        try{
            $newdata =$data->all()['affaires'];
            for ($i=0; $i<count($newdata) ; $i++) {
                # code...
                $affairenature=new AffaireNature();
                $el=$newdata[$i];
                $abr_v = empty($el['Abr_v']) ? substr($el['Name'], 0, 3) : $el['Abr_v'];
                $affairenature->Name = $el['Name'];
                $affairenature->Abr_v = $abr_v;
                $affairenature->organisation_id=$this->organisation_id;
                $affairenature->save();
                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessNature . $el['Name'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
            }
            return $newdata;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function destroy($id)
    {
        try{
            return  AffaireNature::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
