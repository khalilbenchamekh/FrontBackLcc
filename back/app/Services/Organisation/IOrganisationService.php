<?php

namespace App\Services\Organisation;

use App\Organisation;

interface IOrganisationService
{
    public function getAllOrganisation($req);
    public function getOrganisation($id):?Organisation;
    public function storeOrganisation($request,$cto): ?Organisation;
    public function editOrganisation($id,$request);
    public function checkEmailOraganisation($id,$email);
    public function deleteOrganisation($id);
    public function enableOrganisation($id);
    public function disableOrganisation($id);
    public function blockedOrganisation($id);
    public function saveImageOrganisation($id,$request,$base64=false);
    public function deleteImageOrganisation($id);
    public function getImageOrganisation($id);
    public function getOrganisationByCto($id);
    public function renameFileOrganisation($from ,$to);
    public function getMyOrganisation():Organisation;
}
