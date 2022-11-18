<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 16/06/2020
 * Time: 13:08
 */

namespace App\Http\Controllers\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'original_filename' => $this->original_filename,
            //'organisation_id' => $this->organisation_id,
            'customClaims' => ['Role' => $this->roles !==[]  ?$this->roles[0]->name : 'user'],
        ];
    }
}
