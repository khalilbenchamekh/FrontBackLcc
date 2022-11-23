<?php
namespace App\Repository\Intermediate;
use App\Models\Intermediate;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
class IntermediateRepository implements IIntermediateRepository
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
            $intermediate= new Intermediate();
            $intermediate->organisation_id=$this->organisation_id;
            $intermediate->name=$request['name'];
            $intermediate->second_name=$request['second_name'];
            $intermediate->Street=$request['Street'];
            $intermediate->Street2=$request['Street2'];
            $intermediate->city=$request['city'];
            $intermediate->ZIP_code=$request['ZIP_code'];
            $intermediate->Country=$request['Country'];
            $intermediate->Function=$request['Function'];
            $intermediate->tel=$request['tel'];
            $intermediate->Cour=$request['Cour'];
            $intermediate->fees=isset($request['fees'])?$request['fees']:null;

            $intermediate->save();

            return $intermediate;
        }catch (\Exception $exception){
            dd($exception->getMessage());
            $this->Log($exception);
            return null;
        }
    }
    public function index($request,$order=null)
    {
        try {
            $intermediate=  Intermediate::
                select();
                if(!is_null($order))
                 {
                    $intermediate->latest();
                 }
                 $intermediate->where("organisation_id","=",$this->organisation_id)
                 ->paginate($request['limit'],['*'],'page',$request['page']);

            return $intermediate;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try {
            //code...
            return Intermediate::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update(Intermediate $intermediate,$request)
    {
        try {
            //code...
            $intermediate->organisation_id=$this->organisation_id;
            $intermediate->name=$request['name'];
            $intermediate->second_name=$request['second_name'];
            $intermediate->Street=$request['Street'];
            $intermediate->Street2=$request['Street2'];
            $intermediate->city=$request['city'];
            $intermediate->ZIP_code=$request['ZIP_code'];
            $intermediate->Country=$request['Country'];
            $intermediate->Function=$request['Function'];
            $intermediate->tel=$request['tel'];
            $intermediate->Cour=$request['Cour'];
            $intermediate->fees=isset($request['fees'])?$request['fees']:null;

            $intermediate->save();

            return $intermediate;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try {
            return  Intermediate::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
