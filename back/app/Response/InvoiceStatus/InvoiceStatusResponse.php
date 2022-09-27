<?php



namespace App\Response\InvoiceStatus;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceStatusResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            "name"=>$this->name,
            "organisation_id"=>$this->organisation_id
        ];
    }
}


