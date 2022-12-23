<?php
namespace App\Repository\Charge;
use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Charges;
use App\Models\InvoiceStatus;
use App\Models\TypesCharge;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargeRepository implements IChargeRpository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::user() ? Auth::user()->organisation_id : null;
    }

    public function index($request)
    {
        try{
            return DB::table('charges')
                ->where('organisation_id','=',$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);

        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($request)
    {
        try {
            $charges = new Charges();

            $charges->organisation_id =$this->organisation_id;
            $charges->typeSchargeId =$request['typeSchargeId'];
            $charges->others =$request['others']? $request['others'] : null;
            $charges->observation = $request['observation']? $request['observation'] : null;
            $charges->desi =$request['desi'];
            $charges->date_fac =$request['date_fac'];
            $charges->date_pai =$request['date_pai'];
            $charges->date_del =$request['date_del'];
            $charges->unite =$request['unite'];
            $charges->num_quit =$request['num_quit'];
            $charges->archive =$request['archive'];
            $charges->isPayed =$request['isPayed'];
            $charges->reste =$request['reste'];
            $charges->avence =$request['avence'];
            $charges->somme_due =$request['somme_due'];
            // $in = InvoiceStatus::find($request['invoiceStatus_id']);
            // $ty = TypesCharge::find($request['typeSchargeId']);
            $charges->invoiceStatusId->$request['invoiceStatus_id'];

            $charges->save();


            return $charges;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try {
            return Charges::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function update($prevElem,$data)
    {
        try {
            $prevElem->update($data->all());
            // $subject = LogsEnumConst::Update . LogsEnumConst::Charge .$data['REQ_TIT'];
            // $logs = new LogActivity();
            // $logs->addToLog($subject, $data);
            return $prevElem;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try{
            return  Charges::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

}
