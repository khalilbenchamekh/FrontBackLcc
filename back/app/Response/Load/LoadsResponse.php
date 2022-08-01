<?php

namespace App\Response\Load;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LoadsResponse extends ResourceCollection
{
    public function toArray($request)
    {
     //   return parent::toArray($request); // TODO: Change the autogenerated stub
        $collection=$this->collection->toArray();
        return array_map(fn($collection)=>new LoadResponse($collection),$collection);

    }
}