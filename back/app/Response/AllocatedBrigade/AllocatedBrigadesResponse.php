<?php


namespace App\Response\AllocatedBrigade;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllocatedBrigadesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=is_array($this->collection)?$this->collection:$this->collection->toArray();
        return array_map(fn($collection)=>new AllocatedBrigadeResponse($collection),$collection);
    }
}

