<?php
namespace App\Repository\BusinessManagement;
use App\Models\Affaire;
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
        $this->organisation_id = Auth::user()->organisation_id;
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
    public function store($request,$affaire = null)
    {
        try{
            $buisnessManagement=new BusinessManagement();
            $buisnessManagement->DATE_ENTRY=$request["DATE_ENTRY"];
            $buisnessManagement->DATE_ENTRY=$request["DATE_ENTRY"];
            $buisnessManagement->DATE_LAI=isset($request["ttc"])?$request["ttc"]:null;
            $buisnessManagement->latitude=isset($request["latitude"])?$request["latitude"]:null;
            $buisnessManagement->longitude=isset($request["longitude"])?$request["longitude"]:null;
            if($affaire instanceof Affaire)  $buisnessManagement->membership()->associate($affaire);
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
    public function businessManagement($membership_id,$relation)
    {
        try{
            $buisnessManagement=BusinessManagement::where("membership_id", '=', $membership_id)
            ->where("organisation_id","=",$this->organisation_id)
            ->where('membership_type', 'like', '%' . $relation)->first();
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
    public function getLocations()
    {
        try {
            return BusinessManagement::
            where('longitude', '!=', 'null')
                ->where(function ($query) {
                    $query->where('latitude', '!=', 'null');
                })
                ->where('organisation_id','=',$this->organisation_id)
                ->select(
                    DB::raw("membership_type"),
                    DB::raw("COUNT(membership_type) as count_type"),
                    'longitude',
                    'latitude'
                )
                ->groupBy(["membership_type"])
                ->groupBy(["longitude", "latitude"])
                ->get();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
