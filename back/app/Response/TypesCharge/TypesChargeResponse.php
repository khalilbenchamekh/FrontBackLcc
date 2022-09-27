<?php


namespace App\Response\TypesCharge;

use Illuminate\Http\Resources\Json\JsonResource;

class TypesChargeResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'organisation_id'=>$this->organisation_id
        ];
    }
}
