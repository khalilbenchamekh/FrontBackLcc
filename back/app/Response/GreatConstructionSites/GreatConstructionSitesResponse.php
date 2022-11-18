<?php

namespace App\Response\GreatConstructionSites;

use Illuminate\Http\Resources\Json\JsonResource;

class GreatConstructionSitesResponse extends JsonResource
{
    public function toArray($request)
    {
     //   return parent::toArray($request); // TODO: Change the autogenerated stub
        return [
            "id"=>$this->id,
            "price"=>$this->price,
            'location_id'=>$this->location_id,
            'Market_title'=>$this->Market_title,
            'resp_id'=>$this->resp_id,
            'DATE_LAI'=>$this->DATE_LAI,
            'Execution_phase'=>$this->Execution_phase,
            'State_of_progress'=>$this->State_of_progress,
            'date_of_receipt'=>$this->date_of_receipt,
            'Execution_report'=>$this->Execution_report,
            'Class_service'=>$this->Class_service,
            'fees_decompte'=>$this->fees_decompte,
        ];
    }
}