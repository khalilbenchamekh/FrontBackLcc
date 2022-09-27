<?php

namespace App\Response\FolderTechNature;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderTechNatureResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "Name"=>$this->Name,
            "Abr_v"=>$this->Abr_v
        ];
    }
}
