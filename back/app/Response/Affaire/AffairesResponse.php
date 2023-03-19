<?php

namespace App\Response\Affaire;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AffairesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->all();
        return array_map(fn($collection)=>new AffaireResponse($collection),$collection);
    }
}
