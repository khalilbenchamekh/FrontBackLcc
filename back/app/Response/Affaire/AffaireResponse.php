<?php

namespace App\Response\Affaire;

use Illuminate\Http\Resources\Json\JsonResource;

class AffaireResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "advanced"=>$this->advanced,
            "organisation_id "=>$this->organisation_id,
            "REF"=>$this->REF,
            "PTE_KNOWN"=>$this->PTE_KNOWN
        ];
    }
}
