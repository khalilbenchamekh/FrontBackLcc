<?php
namespace App\Response\Mission;
use App\Response\UserData;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionResponse extends JsonResource
{
    public function toArray($request)
    {
        return[
            "id"=>$this->id,
            "text"=>$this->text,
            "description"=>$this->description,
            "startDate"=>$this->startDate,
            "endDate"=>$this->endDate,
            "user" => UserData::fromModel($this->User()),
            "allDay"=>$this->allDay
        ];
    }
}
