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
        $this->organisation_id = Auth::User()->organisation_id;
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
    public function show($id)
    {}
    public function update($prevElem,$data)
    {}
    public function destroy($request)
    {}
}
