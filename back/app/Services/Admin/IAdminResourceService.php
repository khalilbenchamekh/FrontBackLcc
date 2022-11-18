<?php

namespace App\Services\Admin;
interface IAdminResourceService{
    public function setUsers($role,$user,$attach_or_detach);
    public function getUsers($request);
    public function getRoles();
    public function getRoutes();
    public function getPermissions();
    public function getDefaultElementOfDashBoard($table,$from,$to,$orderBy);
    public function logActivity($request);
}
