<?php

namespace App\Services\Admin;

interface IAdminService
{
    public function getAllUser($data);
    public  function getUserCount():?int;
    public  function getUser($id);
    public function createUserToOrganisation($request,$organisation_id);
    public function createUser($request);
    public function editUser($request,$id);
    public function deleteUser($id);
    public function enableUser($id);
    public function disableUser($id);
    public function generatePassword($id,$newPassword);
    public function block($id);
    public function addIdOrganisationToCto($cto,$organisation_id);
    public function getAllUserOrganisationToEmail($organisation_id,$cto_id);
    public function saveImageUser($id, $request, $base64);
    public function getImageUser($id);

}
