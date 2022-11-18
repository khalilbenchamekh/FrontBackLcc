<?php

namespace App\Response\FileModel;

use Illuminate\Http\Resources\Json\JsonResource;

class FileModelResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "filename"=>$this->filename,
        ];
    }
}
