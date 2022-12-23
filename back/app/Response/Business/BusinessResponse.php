<?php



namespace App\Response\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "Street" => $this->Street,
            "Street2" => isset($this->Street2) ? $this->Street2 : null,
            "city" => $this->city,
            "ZIP_code" => $this->ZIP_code,
            "Country" => $this->Country,
            "ICE" => isset($this->membership) ? $this->membership->ICE : null,
            "id_mem" => isset($this->membership) ? $this->membership->id : null,
            "RC" => isset($this->membership) ? $this->membership->RC : null,
            "tel" => isset($this->membership) ? $this->membership->tel : null,
            "Cour" => isset($this->membership) ? $this->membership->Cour : null
        ];
    }
}

