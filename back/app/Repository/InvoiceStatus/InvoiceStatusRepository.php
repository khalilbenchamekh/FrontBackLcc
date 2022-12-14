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
        $this->organisation_id = Auth::user()->organisation_id;
    }
    public function save($request)
    {
        try {
            //code...
            $data = $request->all();

            $intermediate= new InvoiceStatus();
            $intermediate->organisation_id=$this->organisation_id;
            $intermediate->name=$data['name'];

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
            $data = $request->all();
            return InvoiceStatus::
                select()
                ->where("organisation_id","=",$this->organisation_id)
                ->paginate($data['limit'],['*'],'page',$data['page']);
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
    public function destroy($model,$id)
    {
        try {
            return $model->delete();
        } catch (\Exception $exception) {
             $this->Log($exception);
             return null;
        }
    }
}
