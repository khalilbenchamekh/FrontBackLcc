<?php



namespace App\Response\FolderTechSituation;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderTechSituationResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'Name'=>$this->Name,
            'orderChr'=>$this->orderChr
        ];
    }
}




