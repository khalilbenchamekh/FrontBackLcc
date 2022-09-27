<?php


namespace App\Response\Intermediate;

use Illuminate\Http\Resources\Json\JsonResource;

class IntermediateResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            "name"=>$this->name,
            "name"=>$this->name,
            "second_name"=>$this->second_name,
            "Street"=>$this->Street,
            "Street2"=>$this->Street2,
            "city"=>$this->city,
            "ZIP_code"=>$this->ZIP_code,
            "Country"=>$this->Country,
            "Function"=>$this->Function,
            "tel"=>$this->tel,
            "Cour"=>$this->Cour
        ];
    }
}



