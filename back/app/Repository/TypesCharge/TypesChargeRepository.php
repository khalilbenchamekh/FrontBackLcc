<?php


namespace App\Repository\TypesCharge;

use App\Models\TypesCharge;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class TypesChargeRepository implements ITypesChargeRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function save($request)
    {
        try {
            //code...
            $typescharge= new TypesCharge();
            $typescharge->name=$request['name'];
            $typescharge->organisation_id=$this->organisation_id;
            $typescharge->save();

            return $typescharge;

        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try {
            return TypesCharge::
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
            return TypesCharge::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update(TypesCharge $typesCharge,$request)
    {
        try {
            //code...
            $typesCharge->name=$request['name'];
            $typesCharge->organisation_id=$this->organisation_id;
            $typesCharge->save();

            return $typesCharge;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($typesCharge)
    {
        try {
            $deleted=$typesCharge;
            $deleted->delete();
            return $typesCharge;
        } catch (\Exception $exception) {
             $this->Log($exception);
             return null;
        }
    }
}

