<?php
namespace App\Response\LoadTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadTypeResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "name"=>$this->name,
            "organisation_id"=>$this->organisation_id
        ];
    }
}
