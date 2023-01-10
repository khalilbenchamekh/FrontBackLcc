<?php

namespace App\Services\Role;

interface IRoleService
{
public function get($id);
public function getBy(array $filter);
public function like($name);
public function likePermission($name);
public function getRoleByName(string $name);
}
