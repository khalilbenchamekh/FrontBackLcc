<?php


namespace App\Response\FolderTechSituation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FolderTechSituationsResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->all();
        return array_map(fn($value)=>new FolderTechSituationResponse($value),$collection);
    }
}



