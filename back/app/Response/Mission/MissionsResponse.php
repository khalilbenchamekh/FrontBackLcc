<?php
namespace App\Response\Mission;
use Illuminate\Http\Resources\Json\ResourceCollection;
class MissionsResponse extends ResourceCollection

{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
        return array_map(fn($collection)=>new MissionResponse($collection),$collection);
    }
}
