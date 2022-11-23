<?php


namespace App\Response\AllocatedBrigade;



use Illuminate\Http\Resources\Json\ResourceCollection;

class AllocatedBrigadeResponse extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            "organisation_id"=>property_exists($this,"organisation_id")?$this->organisation_id:$this->resource["organisation_id"],
            'name'=>$this->name
        ];
    }
}



