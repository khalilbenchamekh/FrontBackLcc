<?php


namespace App\Repository\BusinessManagement;

use App\Models\BusinessManagement;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessManagementRespositry implements IBusinessManagementRespositry
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id=1;
    }
    public function index($request)
    {
        try{
            $buisnessManagement=DB::table(" business_managements")
            ->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $buisnessManagement;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($request)
    {
        try{
            $buisnessManagement=new BusinessManagement();
            $buisnessManagement->DATE_ENTRY=$request["DATE_ENTRY"];
            $buisnessManagement->DATE_LAI=$request["DATE_LAI"];
            $buisnessManagement->latitude=isset($request["latitude"])?$request["latitude"]:null;
            $buisnessManagement->longitude=isset($request["longitude"])?$request["longitude"]:null;
            $buisnessManagement->save();
            return $buisnessManagement;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try{
            $buisnessManagement=BusinessManagement::findOrFail($id)->where('organisation_id','=',$this->organisation_id);
            return $buisnessManagement;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function update($perElem,$data)
    {
        try{
            $perElem->update($data->all());
            return $perElem;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try{
            return  BusinessManagement::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
