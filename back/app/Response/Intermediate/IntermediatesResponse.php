<?php


namespace App\Response\Intermediate;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IntermediatesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection =$this->collection->all();
        return array_map(fn($value)=>new IntermediateResponse($value),$collection);
    }
}


