<?php
namespace App\Repository\LoadTypes;
use App\Repository\LoadTypes\ILoadTypesRepository;
use Illuminate\Support\Facades\DB;
use App\Repository\Log\LogTrait;
use App\Models\LoadTypes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoadTypesRepository implements ILoadTypesRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function index($request,$order=null)
    {
        try{
            $loadType= LoadTypes::select("*");
            if(!is_null($order)){
                $loadType->latest();
            }
            $loadType->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $loadType;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        try{
            $loadType= new LoadTypes();
            $loadType->organisation_id=$this->organisation_id ;
            $loadType->name=$data["name"];
            $loadType->created_at=Carbon::now();
            $loadType->updated_at=Carbon::now();
            $loadType->save();
           return $loadType;

        }catch(\Exception $exception){
            dd($exception->getMessage());
            $this->Log($exception);
            return null;
        }
    }
    public function edit($data,$perLoadType)
    {
        try{
            $perLoadType->organisation_id=$this->organisation_id ;
            $perLoadType->name=$data["name"];
            $perLoadType->updated_at=Carbon::now();
            $perLoadType->save();
            return $perLoadType;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function delete($id)
    {
        try{
             return LoadTypes::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function get($id)
    {
        try{
          return LoadTypes::where("id","=",$id)
          ->where("organisation_id",'=',$this->organisation_id)->first();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function saveManyLoadTypes($data)
    {
        try{
            $multiLoadType=[];
            foreach ($data['loadtype'] as $value) {
                # code...
                $loadTypes= new LoadTypes();
                $loadTypes->name=$value['name'];
                $loadTypes->organisation_id=$this->organisation_id;
                $loadTypes->save();
                array_push($multiLoadType,$loadTypes);
            }
            return $multiLoadType;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
