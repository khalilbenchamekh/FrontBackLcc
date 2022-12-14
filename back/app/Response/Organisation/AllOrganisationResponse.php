<?php

namespace App\Response\Organisation;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllOrganisationResponse extends ResourceCollection
{

    public function toArray($request): array
    {
//        return parent::toArray($request); // TODO: Change the autogenerated stub
        $collection = $this->collection->toArray();
        return[
          "collection"=>array_map(fn ($collection)=> new OrganisationResponse($collection), $collection)
        ];
    }

}
