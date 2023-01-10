<?php

namespace App\Repository\Role;

use App\Models\Permission;
use App\Models\Role;
use App\Repository\Log\LogTrait;

class RoleRepository implements IRoleRepository
{
    use LogTrait;

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function getBy(array $filter)
    {
        // array $filter [['key'=>name,"value"=>owner]]
        // TODO: Implement getBy() method.

        try {
            $role= new Role();
            foreach ($filter as $item){
                $role->where($item['key'],"=",$item['value']);
            }
            $role->get();
            return $role;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function like($name)
    {
        try {
            $role= Role::where('name', 'like', '%' . $name . '%')->first();
            return $role;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function likePermission($name)
    {
        try {
            $res= Permission::where('name', 'like', '%' . $name . '%')->first();
            return $res;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getRoleByName(string $name)
    {
        try {
            //code...
            return Role::where("name","=",$name)->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
