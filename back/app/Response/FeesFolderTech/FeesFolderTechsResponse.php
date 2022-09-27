<?php

namespace App\Response\FeesFolderTech;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FeesFolderTechsResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->toArray();
        return array_map(fn($collection)=>new FeesFolderTechResponse($collection),$collection);
    }
}
