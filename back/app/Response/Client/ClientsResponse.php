<?php
namespace App\Response\Client;
use App\Response\Client\ClientResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
class ClientsResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
       return array_map(fn($collection)=>new ClientResponse($collection),$collection);
    }
}

