<?php

namespace App\Response\Notification;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationsReponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
        return array_map(fn($collection)=>new NotificationReponse($collection),$collection);
    }
}
