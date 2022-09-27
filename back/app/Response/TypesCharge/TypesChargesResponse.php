<?php


namespace App\Response\TypesCharge;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypesChargesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection = $this->collection->all();
        return array_map(fn($value)=>new TypesChargeResponse($value),$collection);
    }
}
