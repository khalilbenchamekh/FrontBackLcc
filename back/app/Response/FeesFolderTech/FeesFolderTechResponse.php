<?php

namespace App\Response\FeesFolderTech;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesFolderTechResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "Name"=>$this->Name,
        ];
    }
}
