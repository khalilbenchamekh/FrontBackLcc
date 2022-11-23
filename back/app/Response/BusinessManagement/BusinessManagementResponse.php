<?php

namespace App\Response\BusinessManagements;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BusinessManagementResponse extends ResourceCollection
{
    public function toArray($request)
    {
        return[
            "organisation_id"=>property_exists($this,"organisation_id")?$this->organisation_id:$this->resource["organisation_id"],
            "longitude"=>property_exists($this,"longitude")?$this->Name:$this->resource["longitude"],
            "latitude"=>property_exists($this,"latitude")?$this->orderChr:$this->resource["latitude"],
            "DATE_ENTRY"=>property_exists($this,"DATE_ENTRY")?$this->orderChr:$this->resource["DATE_ENTRY"],
            "DATE_LAI"=>property_exists($this,"DATE_LAI")?$this->orderChr:$this->resource["DATE_LAI"],
        ];
    }
}

