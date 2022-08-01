<?php

namespace App\Repository\Role;

interface IRoleRepository
{
    public function get($id);
    public function getBy(array $filter);
}
