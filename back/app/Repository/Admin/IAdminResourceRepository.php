<?php

namespace App\Repository\Admin;
interface IAdminResourceRepository{
    public function getUsers();
    public function getRoles();
    public function getRoutes();
    public function getPermissions();
    public function getDefaultElementOfDashBoard($table,$from,$to,$orderBy);
    public function logActivity($request);
}
