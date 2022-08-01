<?php

namespace App\Services\Role;

interface IRoleService
{
public function get($id);
public function getBy(array $filter);
}
