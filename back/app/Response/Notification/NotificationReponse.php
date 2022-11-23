<?php

namespace App\Response\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationReponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            "organisation_id"=>property_exists($this,"organisation_id")?$this->organisation_id:$this->resource["organisation_id"],
            'description'=>$this->description
        ];
    }
}
