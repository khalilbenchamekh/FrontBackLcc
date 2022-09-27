<?php

namespace App\Repository\Admin;
interface IAdminRepository
{
    public function getAllUser($limit,$page);
    public function checkEmail($id);
    public function editUser($user,$data);
    public function createUser($data);
    public function deleteUser($user);
    public function enable($user);
    public function disable($user);
    public function generatePassword($user,$newPassword);
    public function getUserCount():int;
    public function block($user,$action);
    public function addIdToCto($user,$id);
    public function getAllUserOrganisationToEmail($organisation_id,$cto_id);
    public function createUserToOrganisation($data,$organisation_id);
    public function getByUser($id);
    public function saveImage($user, $fileName);
}
