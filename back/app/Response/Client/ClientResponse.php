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
            "Street2" => $this->Street2,
            "city" => $this->city,
            "ZIP_code" => $this->ZIP_code,
            "Country" => $this->Country,
            "ICE" => $this->membership->ICE,
            "id_mem" => $this->membership->id,
            "RC" => $this->membership->RC,
            "tel" => $this->membership->tel,
            "Cour" => $this->membership->Cour
        ];
    }
}
class ClientParticularResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "name"=>$this->name,
            "Street" => $this->Street,
            "Street2" => $this->Street2,
            "city" => $this->city,
            "ZIP_code" => $this->ZIP_code,
            "Country" => $this->Country,
            "id_mem" => $this->membership->id,
            "tel" => $this->membership->tel,
            "Function" => $this->membership->Function,
            "Cour" => $this->membership->Cour
        ];
    }
}
