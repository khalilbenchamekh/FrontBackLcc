<?php

namespace App\Response\Fees;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "advanced"=>$this->advanced
        ];
    }
}
