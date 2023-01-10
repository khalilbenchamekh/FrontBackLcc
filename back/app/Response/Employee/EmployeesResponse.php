<?php

namespace App\Response\Employee;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeesResponse extends ResourceCollection
{
    public function toArray($request)
    {
        $collection = $this->collection->all();
        return array_map(fn($collection)=>new EmployeeResponse($collection),$collection);
    }
}
