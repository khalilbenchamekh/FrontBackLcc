<?php

namespace App\Repository\Role;

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
}
