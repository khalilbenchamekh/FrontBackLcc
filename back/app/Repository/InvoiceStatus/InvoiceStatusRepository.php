<?php
namespace App\Repository\InvoiceStatus;
use App\Models\InvoiceStatus;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class InvoiceStatusRepository implements IInvoiceStatusRepository
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
            $intermediate= new InvoiceStatus();
            $intermediate->organisation_id=$this->organisation_id;
            $intermediate->name=$request['name'];

            $intermediate->save();

            return $intermediate;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try {
            return InvoiceStatus::
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
            return InvoiceStatus::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update(InvoiceStatus $intermediate,$request)
    {
        try {
            //code...
            $intermediate->organisation_id=$this->organisation_id;
            $intermediate->name=$request['name'];
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
            return  InvoiceStatus::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->destroy();
        } catch (\Exception $exception) {
             $this->Log($exception);
             return null;
        }
    }
}
