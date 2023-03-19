<?php

namespace App\Response\FolderTech;


use Illuminate\Http\Resources\Json\ResourceCollection;

class FolderTechsResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->all();
        return array_map(fn($value)=>new FolderTechResponse($value),$collection);
    }
}
