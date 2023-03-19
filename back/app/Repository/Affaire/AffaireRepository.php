<?php
namespace App\Repository\Affaire;
use App\Models\Affaire;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;

class AffaireRepository implements IAffaireRepository
{
    use LogTrait;
    private $current_user;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::user() ? Auth::user()->organisation_id : null;
        $this->current_user = Auth::user() ? Auth::user() : null;;
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
            return Affaire::where($conditions["name"],'=',$conditions["value"])->get();
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
        $nature_Abr_v_name = $request->input('nature_Abr_v_name');
        $place = $request->input('place');
        $conditions = ["name"=>"nature_name" , "value"=>$nature_name];
        $count = count($this->getAffaireBy($conditions));
        $count++;
        $ref = $nature_Abr_v_name.$count."_" . $place . "_" . $year;
        $affaire = new Affaire();
        $affaire->REF = $ref;
        $affaire->PTE_KNOWN = $request->input('PTE_KNOWN');
        $affaire->TIT_REQ = $request->input('TIT_REQ');
        $affaire->place = $request->input('place');
        $affaire->DATE_ENTRY =Carbon::parse( $request->input('DATE_ENTRY'));
        $affaire->DATE_LAI =Carbon::parse($request->input('DATE_LAI'));
        $affaire->UNITE = $request->input('UNITE');
//        $affaire->ARCHIVE=$request->input('ARCHIVE');
//        $affaire->isValidate=$request->input('isValidate');
//        $affaire->isPayed=$request->input('isPayed');
        $affaire->PRICE = $request->input('place');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->aff_sit_id = $request->input('aff_sit_id');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->client_id = $request->input('client_id');
        $affaire->resp_id = $request->input('resp_id');
        $affaire->nature_name = $request->input('nature_name');
        $affaire->organisation_id = $this->organisation_id;
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
            $perElem->DATE_ENTRY = Carbon::parse($request->input('DATE_ENTRY'));
            $perElem->DATE_LAI = Carbon::parse($request->input('DATE_LAI'));
            $perElem->UNITE = $request->input('UNITE');
            // $perElem->ARCHIVE = $request->input('ARCHIVE');
            // $perElem->isValidate = $request->input('isValidate');
            // $perElem->isPayed = $request->input('isPayed');
            $perElem->PRICE = $request->input('PRICE');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->aff_sit_id = $request->input('aff_sit_id');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->client_id = $request->input('client_id');
            $perElem->resp_id = $request->input('resp_id');
            $perElem->nature_name = $request->input('nature_name');
            $perElem->organisation_id = $this->organisation_id;
            $perElem->PRICE = $request->input('place');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->aff_sit_id = $request->input('aff_sit_id');
            $perElem->Inter_id = $request->input('Inter_id');
            $perElem->client_id = $request->input('client_id');
            $perElem->resp_id = $request->input('resp_id');
            $perElem->nature_name = $request->input('nature_name');
            $perElem->save();
            return $perElem;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
    public function destroy($id)
    {
        try {
            $model= Affaire::where("organisation_id",'=',$this->organisation_id)->find($id);
            $deleted = $model;
            $deleted->delete();
            return $model;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function getAffaireBetween($from, $to)
    {
        try {
            return Affaire::whereBetween('DATE_LAI', [$from, $to])
            ->select('REF')
            ->get();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}

