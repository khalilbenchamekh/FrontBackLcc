<?php


namespace App\Repository\Mission;

use App\Models\Mission;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class MissionRepository implements IMissionRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function save($request,$affaire = null)
    {
        try {
            $mission= new Mission();
            $mission->organisation_id=$this->organisation_id;
            $mission->user_id=$request('user_id');
            $mission->description =$request('description')!==null?$request('description'):null;
            $mission->startDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
            $mission->endDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
            $mission->allDay =$request('allDay');
            $mission->save();
            return $mission;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try {
            return Mission::
                select()
                ->where("organisation_id","=",$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
     public function getMissionOfUSer($userID)
    {
        try {
            return Mission::
                select()
                ->where("organisation_id","=",$this->organisation_id)
                ->where("user_id","=",$userID)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try {
            //code...
            return Mission::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->get();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update($data,$id)
    {
        try {
            //code...
            $mission= $this->show($id);
            if($mission instanceof Mission){
                $mission->user_id=$data('user_id');
                $mission->organisation_id=$this->organisation_id;
                $mission->description =$data('description')!==null?$data('description'):null;
                $mission->startDate = date("Y-m-d H:i:s", strtotime(date($data->startDate)));
                $mission->endDate = date("Y-m-d H:i:s", strtotime(date($data->endDate)));
                $mission->allDay =$data('allDay');
                $mission->update();
            }
            return null;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try {
            //code...
            return  Mission::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
