<?php

namespace App\Response\GreatConstructionSitess;
use App\Response\GreatConstructionSites\GreatConstructionSitesResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class GreatConstructionSitessResponse extends JsonResource
{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
        return array_map(fn($collection)=>new GreatConstructionSitesResponse($collection),$collection);
    }
}
