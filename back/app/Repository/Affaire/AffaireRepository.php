<?php

namespace App\Repository\Affaire;

use App\Models\Affaire;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use DateTime;


class AffaireRepository implements IAffaireRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function getBusiness($request)
    {
        try {
            return Affaire::latest()
            ->select('REF', 'id')
            ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getAffaireBy(array $conditions)
    {
        try{
            $affaire = new Affaire();
            foreach($conditions as $condition){
                $affaire::where($condition->name,'=',$condition->value);
            }
            $affaire->get();
            return $affaire;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function save($request)
    {
        try{
        $nature_name = $request->input('nature_name');
        $now = new DateTime();
        $year = $now->format("Y");
        $conditions=['nature_name'=>$nature_name];
        $nature_Abr_v_name = $request->input('nature_Abr_v_name');
        $place = $request->input('place');
        $count = $this->getAffaireBy($conditions)->count();
        $count++;
        $ref = $nature_Abr_v_name.$count."_" . $place . "_" . $year;
        $affaire = new Affaire();
        $affaire->REF = $ref;
        $affaire->PTE_KNOWN = $request->input('PTE_KNOWN');
        $affaire->TIT_REQ = $request->input('TIT_REQ');
        $affaire->place = $request->input('place');
        $affaire->DATE_ENTRY = $request->input('DATE_ENTRY');
        $affaire->DATE_LAI = $request->input('DATE_LAI');
        $affaire->UNITE = $request->input('UNITE');
//        $affaire->ARCHIVE=$request->input('ARCHIVE');
//        $affaire->isValidate=$request->input('isValidate');
//        $affaire->isPayed=$request->input('isPayed');
        $affaire->PRICE = $request->input('PRICE');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->aff_sit_id = $request->input('aff_sit_id');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->client_id = $request->input('client_id');
        $affaire->resp_id = $request->input('resp_id');
        $affaire->nature_name = $request->input('nature_name');
        $affaire->save();

        return $affaire;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try {
            return Affaire::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();;

        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }

    }
    public function index($request)
    {
        try{
            $employees=Affaire::where('organisation_id','=',$this->organisation_id)
            ->latest()
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $employees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function update(Affaire $perElem,$request)
    {
        try{
            $perElem->PTE_KNOWN = $request->input('PTE_KNOWN');
            $perElem->TIT_REQ = $request->input('TIT_REQ');
            $perElem->place = $request->input('place');
            $perElem->DATE_ENTRY = $request->input('DATE_ENTRY');
            $perElem->DATE_LAI = $request->input('DATE_LAI');
            $perElem->UNITE = $request->input('UNITE');
            $perElem->ARCHIVE = $request->input('ARCHIVE');
            $perElem->isValidate = $request->input('isValidate');
            $perElem->isPayed = $request->input('isPayed');
            $perElem->PRICE = $request->input('PRICE');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->aff_sit_id = $request->input('aff_sit_id');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->client_id = $request->input('client_id');
            $perElem->resp_id = $request->input('resp_id');
            $perElem->nature_name = $request->input('nature_name');
            $perElem->update();
            return $perElem;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
    public function destroy($id)
    {
        try {
            return Affaire::where("id","=",$this->current_user)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}

