<?php

namespace App\Response\FolderTechNature;

use App\Response\FeesFolderTech\FeesFolderTechResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FolderTechNaturesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->all();
        return array_map(fn($value)=>new FolderTechNatureResponse($value),$collection);
    }
}
