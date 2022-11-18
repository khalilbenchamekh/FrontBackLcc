<?php

namespace App\Response\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeesResponse extends JsonResource
{
    public function toArray($request)
    {
        $collection =is_array($this->collection)?$this->collection: $this->collection->toArray();
        return array_map(fn($collection)=>new EmployeeResponse($collection),$collection);
    }
}
