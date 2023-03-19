<?php

namespace App\Response\FolderTech;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderTechResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            "REF"=>$this->REF,
            "PTE_KNOWN"=>$this->PTE_KNOWN,
            "TIT_REQ"=>$this->TIT_REQ,
            "place"=>$this->place,
            "DATE_ENTRY"=>$this->DATE_ENTRY,
            "DATE_LAI"=>$this->DATE_LAI,
            "UNITE"=>$this->UNITE,
            "PRICE"=>$this->PRICE,
            "Inter_id"=>$this->Inter_id,
            "folder_sit_id"=>$this->folder_sit_id,
            "client_id"=>$this->client_id,
            "resp_id"=>$this->resp_id,
            "nature_name"=>$this->nature_name,
        ];
    }
}
