<?php

namespace App\Response\FolderTechNature;

use App\Response\FileModel\FileModelResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FilesModelResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection=$this->collection->all();
        return array_map(fn($value)=>new FileModelResponse($value),$collection);
    }
}
