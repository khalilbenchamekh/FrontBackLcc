<?php

namespace App\Services\Organisation;


interface IOrganisationService
{
    public function getAllOrganisation($req);
    public function getOrganisation($id);
    public function storeOrganisation($request,$cto);
    public function editOrganisation($id,$request);
    public function checkEmailOraganisation($id,$email);
    public function deleteOrganisation($id);
    public function enableOrganisation($id);
    public function disableOrganisation($id);
    public function blockedOrganisation($id);
    public function saveImageOrganisation($id,$request,$base64=false);
    public function deleteImageOrganisation($id);
    public function getImageOrganisation($id=null);
    public function getOrganisationByCto($id);
    public function renameFileOrganisation($from ,$to);
    public function getMyOrganisation();
    public function getAllUserOrganisation($id,$req);
    public function getOrganisationWithSupInfo($id=null);
}
