<?php


namespace App\Repository\Charge;

use Illuminate\Http\Resources\Json\JsonResource;

class ChargeResponse  extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "others"=>$this->others,
            "observation"=>$this->observation,
            "num_quit"=>$this->num_quit,
            "desi"=>$this->desi,
            "unite"=>$this->unite,
            "somme_due"=>$this->somme_due,
            "date_fac"=>$this->date_fac,
            "avence"=>$this->avence,
            "reste"=>$this->reste,
            "date_pai"=>$this->date_pai,
            "date_del"=>$this->date_del,
            "invoiceStatusId "=>$this->invoiceStatusId ,
            "typeSchargeId "=>$this->typeSchargeId ,
            "archive"=>$this->archive,
            "isPayed"=>$this->isPayed,
        ];
    }
}

