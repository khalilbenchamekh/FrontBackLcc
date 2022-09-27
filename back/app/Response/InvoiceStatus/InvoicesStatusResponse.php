<?php

namespace App\Response\InvoiceStatus;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoicesStatusResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection = $this->collection->all();
        return array_map(fn($value)=>new InvoiceStatusResponse($value),$collection);
    }
}



