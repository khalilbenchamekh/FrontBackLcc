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
        $this->organisation_id = Auth::User()->organisation_id;
    }
    public function save($request)
    {
        try {
            //code...
            $mission= new Mission();
            $mission->organisation_id=$this->organisation_id;
            $mission->description =$request('description')!==null?$request('description'):null;
            $mission->startDate =  date("Y-m-d H:i:s",strtotime(date($$request('startDate'))));
            $mission->endDate =  date("Y-m-d H:i:s",strtotime(date($request('endDate'))));
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
    public function update(Mission $mission,$request)
    {
        try {
            //code...
            return $mission->update($request->all());
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
