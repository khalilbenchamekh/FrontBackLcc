<?php

namespace App\Services\Role;

use App\Repository\Role\IRoleRepository;

class RoleService implements IRoleService
{
    private $roleRepository;
    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function getBy(array $filter)
    {
        // TODO: Implement getBy() method.
        return $this->roleRepository->getBy($filter);
    }
}
