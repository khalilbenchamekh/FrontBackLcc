<?php

namespace App\Repository\LoadTypes;

use App\Repository\LoadTypes\ILoadTypesRepository;
use Illuminate\Support\Facades\DB;
use App\Repository\Log\LogTrait;
use App\Models\LoadTypes;
use Carbon\Carbon;




class LoadTypesRepository implements ILoadTypesRepository
{
use LogTrait;

    public function index($idUser,$page)
    {

        try{
         $data= DB::table('load_types')->select("*")->where('organisation_id','=',$idUser)->paginate(2, $columns = ['*'], $pageName = 'page', $page = $page);

        return $data;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }

    public function store($data)
    {
       // dd($data);
        try{
            $loadType= new LoadTypes();

            $loadType->organisation_id=$data["organisation_id"];
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
            $perLoadType->organisation_id=$data["organisation_id"];
            $perLoadType->name=$data["name"];

            $perLoadType->save();
            return $perLoadType;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function delete($id,$LoadType)
    {
        try{
            $loadtype=$LoadType::destroy($id);
            return $LoadType;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function get($id)
    {
        try{
          return  $loadtype=LoadTypes::find($id);
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
                $loadTypes->organisation_id=$value['organisation_id'];

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
