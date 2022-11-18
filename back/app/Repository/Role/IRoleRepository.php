<?php
namespace App\Repository\Role;
interface IRoleRepository
{
    public function get($id);
    public function getBy(array $filter);
    public function like($name);
    public function likePermission($name);
}
