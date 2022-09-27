<?php

namespace App\Response\Fees;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FeessResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->toArray();
        return array_map(fn($collection)=>new FeesResponse($collection),$collection);
    }
}
