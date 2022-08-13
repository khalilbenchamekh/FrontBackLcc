<?php

namespace App\Response\Organisation;

use App\Services\Admin\IAdminService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationResponse extends JsonResource
{

    public function toArray($request): array
{
    return  [
        'id'=>$this->id,
        'name'=>$this->name,
        "emailOrganisation"=>$this->emailOrganisation,
        "description"=>$this->description,
        "cto"=>$this->cto,
        "enable"=>$this->activer,
        "blocked"=>$this->blocked
    ];
}

}
