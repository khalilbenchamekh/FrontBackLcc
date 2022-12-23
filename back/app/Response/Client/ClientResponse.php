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
            "Street" => $this->Street,
            "Street2" => isset($this->Street2) ? $this->Street2 : null,
            "city" => $this->city,
            "ZIP_code" => $this->ZIP_code,
            "Country" => $this->Country,
        ];
    }
}

