<?php
namespace App\Repository\Bill;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Repository\Bill\IBillRepository;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class BillRepository implements IBillRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct() {
        $this->organisation_id = Auth::user()->organisation_id;
    }
    public function get($ref){
        try {
            return Bill::where('REF', 'like', $ref)
                ->where("organisation_id","=",$this->organisation_id)
                ->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($data,$ref){
        try {
        $bills = new Bill();
        $bills->devis_date_e = $data->input("devis_date_e");
        $bills->devis_date_c = $data->input("devis_date_c");
        $bills->client_ice = $data->input("client_ice");
        $bills->client_n = $data->input("client_n");
        $bills->Etablissement = $data->input("Etablissement");
        $bills->details = empty($data->input("details")) ? 'details' : $data->input("details");
        $bills->REF = $ref;
        $bills->save();
    }catch (\Exception $exception){
        $this->Log($exception);
        return null;
    }
    }

    public function update($bills,$data,$ref){
        try {
        $bills->devis_date_e = $data->input("devis_date_e");
        $bills->devis_date_c = $data->input("devis_date_c");
        $bills->client_ice = $data->input("client_ice");
        $bills->client_n = $data->input("client_n");
        $bills->Etablissement = $data->input("Etablissement");
        $bills->details = empty($data->input("details")) ? 'details' : $data->input("details");
        $bills->REF = $ref;
        $bills->save();
    }catch (\Exception $exception){
        $this->Log($exception);
        return null;
    }
    }
    public function storeBillDetail($data,$billsId){
        try {
            $i = 0;
        foreach ($data as $detail) {
            {
                $bills_Details = new BillDetail();
                $bills_Details->bills()->associate(
                    $billsId
                );
                if (isset($detail['Un'])) {
                    $bills_Details->Un = $detail['Un'];
                    $bills_Details->Ds = $detail['Ds'];
                    $bills_Details->pt = $detail['pt'];
                    $bills_Details->pu = $detail['pu'];
                    $bills_Details->qt = $detail['qt'];
                } else {
                    $bills_Details->Un = $detail[$i]->Un;
                    $bills_Details->Ds = $detail[$i]->Ds;
                    $bills_Details->pt = $detail[$i]->pt;
                    $bills_Details->pu = $detail[$i]->pu;
                    $bills_Details->qt = $detail[$i]->qt;
                }
                $bills_Details->save();
                $i++;
            }
        }
        return $data;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
