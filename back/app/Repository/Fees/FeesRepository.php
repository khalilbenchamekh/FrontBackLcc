<?php


namespace App\Repository\Fees;

use App\Http\Resources\MemberShipType;
use App\Models\BusinessManagement;
use App\Models\Fees;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class FeesRepository implements IFeesRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function getFolderTechFees($request)
    {
        try {
            //code...
            return Fees::where('type', 'like', '%' . "FolderTech")->where('organisation_id','=',$this->organisation_id)->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getBusinessFees($request)
    {
        try{
            return Fees::where('type', 'like', '%' . "Affaire")->where('organisation_id','=',$this->organisation_id)->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
        $this->Log($exception);
        return null;
        }
    }
    public function index($request)
    {
        try{
            $employees=Fees::where('organisation_id','=',$this->organisation_id)
            ->latest()
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $employees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function saveBusinessFees($busines_mang,$request)
    {
        try{
            $busines_mang_id = $busines_mang[0]->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('advanced');
            $fees = new Fees();
            $fees->businessManagement()->associate(
                $busines_mang_id
            );
            $fees->price = $price;
            $fees->observation = $observation;
            $fees->type = MemberShipType::business;
            $fees->advanced = $advanced;
            $fees->save();

            return $fees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function saveFolderTechFees($busines_mang,$request)
    {
        try{
            $busines_mang_id = $busines_mang[0]->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('advanced');
            $fees = new Fees();
            $fees->businessManagement()->associate(
                $busines_mang_id
            );
            $fees->price = $price;
            $fees->organisation_id=$this->organisation_id;
            $fees->observation = $observation;
            $fees->type = MemberShipType::folderTech;
            $fees->advanced = $advanced;
            $fees->save();

            return $fees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {}
    public function updateBusinessFees($fees,$request,$busines_mang_id)
    {
        dd('res');
        try{
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('id');
            $fees->update([
                'price' => $price,
                'observation' => $observation,
                'type' => MemberShipType::business,
                'business_id' => $busines_mang_id,
                'advanced' => $advanced,
            ]);
            return $fees;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function updateFolderTechFees($fees,$request,$busines_mang_id)
    {
        try{
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('id');
            $fees->update([
                'price' => $price,
                'observation' => $observation,
                'type' => MemberShipType::folderTech,
                'business_id' => $busines_mang_id,
                'advanced' => $advanced,
            ]);
            return $fees;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function getFolderTech()
    {

    }
    public function destroy($request)
    {}
}
