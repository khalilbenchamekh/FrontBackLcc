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

class ChargeRpository implements IChargeRpository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id=Auth::user()->organisation;
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
            $charges->typeSchargeId = $request->input('typeSchargeId');
            $charges->invoiceStatusId = $request->input('invoiceStatus_id');
            $charges->others = $request->input('others');
            $charges->observation = $request->input('observation');
            $charges->desi = $request->input('desi');
            $charges->date_fac = $request->input('date_fac');
            $charges->date_pai = $request->input('date_pai');
            $charges->date_del = $request->input('date_del');
            $charges->unite = $request->input('unite');
            $charges->num_quit = $request->input('num_quit');
            $charges->archive = $request->input('archive');
            $charges->isPayed = $request->input('isPayed');
            $charges->reste = $request->input('reste');
            $charges->avence = $request->input('avence');
            $charges->somme_due = $request->input('somme_due');
            $in = InvoiceStatus::find($request->input('invoiceStatus_id'));
            $ty = TypesCharge::find($request->input('typeSchargeId'));
            $charges->invoiceStatus()->associate($in);
            $charges->typeCharges()->associate($ty);
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
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function update($prevElem,$data)
    {
        try {
            $prevElem->update($data->all());
            $subject = LogsEnumConst::Update . LogsEnumConst::Cadastral .$data['REQ_TIT'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
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
