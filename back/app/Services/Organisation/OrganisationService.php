<?php

namespace App\Services\Organisation;

use App\Repository\Organisation\IOrganisationRepository;
use App\Services\Organisation\IOrganisationService;
use App\Request\OrganisationRequest;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Support\Facades\Auth;
class OrganisationService implements IOrganisationService
{
    private $organisationRepo;
    private $organisation_id;
    private $iSaveFileService;
    public function __construct(ISaveFileService $iSaveFileService,IOrganisationRepository $organisationRepo)
    {
        $this->organisationRepo=$organisationRepo;
        $this->iSaveFileService=$iSaveFileService;
        $this->organisation_id = Auth::User()->organisation_id;
    }

    public function getAllOrganisation($req)
    {
        if(!isset($req))return  null;
        return  $this->organisationRepo->getAll($req);
    }

    public function getOrganisation($id)
    {
        return $this->organisationRepo->getById($id);
    }

    public function getMyOrganisation()
    {
        return $this->organisationRepo->getById($this->organisation_id);
    }

    public function storeOrganisation($request,$cto)
    {
        $req= OrganisationRequest::newRequest($request);
        $org= $this->organisationRepo->store($req,$cto);
        return $org;
    }
    public function editOrganisation($id,$request)
    {
        $req= OrganisationRequest::newRequest($request);
        $res=$this->checkEmailOraganisation($id,$req['emailOrganisation']);
        if(!is_null($res)) {
            $org=$this->getOrganisation($id);
            if (!is_null($org)) {
               $from=$org->name;
               $newOrga= $this->organisationRepo->edit($org,$req);
               if (!is_null($newOrga)) {
                   $to=$newOrga->name;
                   $this->renameFileOrganisation($from,$to);
                   return $newOrga;
               }
           }
        }
        return  null;
    }
    public function checkEmailOraganisation($id,$email)
    {
        return $this->organisationRepo->checkEmail($id,$email);
    }
    public function deleteOrganisation($id)
    {
        $org= $this->getOrganisation($id);
        if(is_null($org)) return null;
        return $this->organisationRepo->delete($org);
    }
    public function enableOrganisation($id)
    {
        $org= $this->getOrganisation($id);
         if (!is_null($org)) {
            return $this->organisationRepo->enable($org);
        }
        return  null;
    }
    public function disableOrganisation($id)
    {
        $org= $this->getOrganisation($id);
         if (!is_null($org)) {
                return $this->organisationRepo->disable($org);
        }
            return  null;
    }
    public function blockedOrganisation($id)
    {
        $org=$this->getOrganisation($id);
         if (!is_null($org)) {
            if($org->blocked==0 || $org->blocked===false || $org->blocked===null){
                return $this->organisationRepo->block($org,1);
            }else{
                return $this->organisationRepo->block($org,0);
            }
        }
        return  null;
    }
    public function saveImageOrganisation($id,$request,$base64=false)
    {
            $org = $this->getOrganisation($id);
            if (!is_null($org)) {
                $fileName =$base64===false ?  $this->iSaveFileService->store_image($org->name, $request,$org->file_avatar_name):
                 $this->iSaveFileService->store_image_if_is_it_base64($org->name, $request,$org->file_avatar_name);
                 $res = $this->organisationRepo->saveImage($org, $fileName);
                 if (!is_null($res)) {
                     return $res;
                 }
            }
            return null;
    }
    public function deleteImageOrganisation($id)
    {
        $org=$this->getOrganisation($id);
        if (!is_null($org)) {
                $this->iSaveFileService->deleteFile($org->name);
                $res= $this->organisationRepo->deleteImage($org);
                if (!is_null($res)) {
                    return $res;
                }
        }
        return null;
    }
    public function getImageOrganisation($id=null)
    {
        $id = is_null($id) ? $this->organisation_id : $id;
        $org= $this->getOrganisation($id);
        if(!is_null($org)){
            $defaultImage= $org->file_avatar_name != null ? $org->file_avatar_name  : "Default.jpg";
            return $this->iSaveFileService->fetchImage($org->name,$defaultImage);
        }
        return null;
    }
    public function getOrganisationWithSupInfo($id=null)
    {
        $id = is_null($id) ? $this->organisation_id : $id;
        $org= $this->getOrganisation($id);
        if(!is_null($org)){
            $defaultImage= $org->file_avatar_name != null ? $org->file_avatar_name  : "Default.jpg";
            $iamgeOrganisation = $this->iSaveFileService->fetchImage($org->name,$defaultImage);
            $resArray=[
                'org' => $org,
                'iamgeOrganisation' => $iamgeOrganisation,
            ];

            return $resArray;
        }

        return null;
    }
    public function getOrganisationByCto($id)
    {
        return $this->organisationRepo->getOrganisationByCto($id);
    }

    public function getAllUserOrganisation($id,$req)
    {
        $organisation=$this->getOrganisation($id);
        if (!is_null($organisation)) {
            $usersOrganisation=$this->organisationRepo->getAllUserOrganisation($organisation,$req);
            return $usersOrganisation;
        }
        return null;
    }

    public function renameFileOrganisation($from ,$to){
        if($from!==$to){
            $path=public_path().'/geoMapping/organisation/';
            $pre=$path.$from;
            $new=$path.$to;
            if(file_exists($pre)){
                rename($pre,$new);
                return true;
            }
        }
    }

}

