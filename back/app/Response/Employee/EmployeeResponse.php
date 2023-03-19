<?php

namespace App\Response\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "organisation_id"=>$this->organisation_id,
            "user_id"=>$this->user_id,
            'profession_number'=>$this->profession_number,
            'position_held'=>$this->position_held,
            'personal_number'=>$this->personal_number,
            'linked_documents'=>$this->linked_documents,
            'Start_date'=>$this->Start_date,
            'Salary'=>$this->Salary,
            'isOnline'=>$this->isOnline,
            "user"=>[
                "id"=> $this->user->id,
                "name"=> $this->user->name,
                "username"=> $this->user->username,
                "email"=> $this->user->email,
            ],
            'workplace'=>$this->workplace,
        ];
    }
}
