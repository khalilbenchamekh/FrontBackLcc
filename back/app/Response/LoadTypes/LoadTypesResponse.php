<?php


namespace App\Response\LoadTypes;



use Illuminate\Http\Resources\Json\ResourceCollection;
class LoadTypesResponse extends ResourceCollection

{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
       return [
        'loadTypes'=>array_map(fn($collection)=>new LoadTypeResponse($collection),$collection)
       ];
    }


}

