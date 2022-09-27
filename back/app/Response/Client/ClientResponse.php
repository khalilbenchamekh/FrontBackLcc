<?php

namespace App\Response\Client;


use Illuminate\Http\Resources\Json\JsonResource;

class ClientResponse extends JsonResource
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
