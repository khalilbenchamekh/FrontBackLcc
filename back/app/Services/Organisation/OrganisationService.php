<?php

namespace App\Services\Organisation;

use App\Organisation;
use App\Repository\Organisation\OrganisationRepository;
use App\Services\Organisation\IOrganisationService;
use App\Request\OrganisationRequest;
use Illuminate\Support\Facades\Auth;

class OrganisationService implements IOrganisationService
{
    private $organisationRepo;
    private $organisation_id;
    public function __construct(OrganisationRepository $organisationRepo)
    {
        $this->organisationRepo=$organisationRepo;
        $this->organisation_id = Auth::User()->organisation;
    }

    /**
     * @param $req
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function getAllOrganisation($req): ?\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if(!isset($req))return  null;
        return  $this->organisationRepo->getAll($req);
    }

    public function getOrganisation($id):?Organisation
    {
        return $this->organisationRepo->getById($id);
    }

    public function getMyOrganisation():Organisation
    {
        return $this->organisationRepo->getById($this->organisation_id);
    }
    /**
     * @param $request
     * @return Organisation|null
     */
    public function storeOrganisation($request,$cto): ?Organisation
    {
        $req= OrganisationRequest::newRequest($request);
        $org= $this->organisationRepo->store($req,$cto);
        return $org;
    }
    public function editOrganisation($id,$request)
    {
        $req= OrganisationRequest::newRequest($request);

        $isExist=$this->checkEmailOraganisation($id,$req['emailOrganisation']);
        if($isExist instanceof Organisation){
                return false;
        }else{
            $org=$this->getOrganisation($id);
            if($org instanceof Organisation){
                $from=$org->name;
                $newOrga= $this->organisationRepo->edit($org,$req);
                if($newOrga instanceof Organisation){
                    $to=$newOrga->name;
                    $this->renameFileOrganisation($from,$to);
                    return $newOrga;
                }
            }else{
                return  null;
            }
        }
    }
    public function checkEmailOraganisation($id,$email)
    {
        $isExist= $this->organisationRepo->checkEmail($id,$email);
        if($isExist instanceof Organisation){
            return $isExist;
        }else{
            return null;
        }
    }
    public function deleteOrganisation($id)
    {
        $org= $this->getOrganisation($id);
        if(!($org instanceof Organisation)) return null;
        $deletedOrg= $this->organisationRepo->delete($org);
        if($deletedOrg instanceof Organisation){
            return  $deletedOrg;
        }else{
            return null;
        }
    }
    public function enableOrganisation($id)
    {
        $org= $this->getOrganisation($id);
        if($org instanceof Organisation){
            return $this->organisationRepo->enable($org);
        }else{
            return  null;
        }
    }
    public function disableOrganisation($id)
    {
        $org= $this->getOrganisation($id);
        if($org instanceof Organisation){
                return $this->organisationRepo->disable($org);

        }else{
            return  null;
        }
    }
    public function blockedOrganisation($id)
    {
        $org=$this->getOrganisation($id);
        if($org instanceof Organisation){
            if($org->blocked==0 || $org->blocked===false || $org->blocked===null){

                return $this->organisationRepo->block($org,1);
            }else{
                return $this->organisationRepo->block($org,0);
            }
        }else{
            return  null;
        }
    }
    public function saveImageOrganisation($id,$request,$base64=false)
    {
            $org = $this->getOrganisation($id);
            if ($org instanceof Organisation) {
                $store = new ImageService();
                $filesArray = [
                    'geoMapping',
                    'geoMapping/organisation/' . $org->name,
                ];
                if($base64===false){
                    $fileName = $store->store_image($filesArray, $request, "/" . $filesArray[1],$org->file_avatar_name);
                    if (isset($fileName)) {
                        $org = $this->organisationRepo->saveImage($org, $fileName);
                        if ($org instanceof Organisation) {
                            return $org;
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                }
                if ($base64 ===true){
                    $fileName = $store->store_image_if_is_it_base64($filesArray, $request, "/" . $filesArray[1],$org->file_avatar_name);
                    if (isset($fileName)) {
                        $org = $this->organisationRepo->saveImage($org, $fileName);
                        if ($org instanceof Organisation) {
                            return $org;
                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }
                }else{
                    return null;
                }

            }
    }
    public function deleteImageOrganisation($id)
    {
        $org=$this->getOrganisation($id);
        if($org instanceof  Organisation){
            $store= new ImageService();
            $filesArray = [
                'geoMapping',
                'geoMapping/organisation/' . $org->name,
            ];
            $store->deleteFile($filesArray[1],$org->file_avatar_name);
                $org= $this->organisationRepo->deleteImage($org);
                if($org instanceof  Organisation){
                    return $org;
                }else{
                    return  null;
                }
        }
    }
    public function getImageOrganisation($id)
    {
        $org= $this->getOrganisation($id);
        $path = 'geoMapping/organisation/' . $org->name;
        if($org instanceof  Organisation && $org->file_avatar_name != null){
            $image = new ImageService();
            return $image->fetchImage($path,$org->file_avatar_name);
        }
        $defaultImage="Default.jpg";
        $path='geoMapping/organisation';
        if($org instanceof  Organisation && $org->file_avatar_name === null){
            $image = new ImageService();
            return $image->fetchImage($path,$defaultImage);
        }
    }
    public function getOrganisationByCto($id)
    {
        return $this->organisationRepo->getOrganisationByCto($id);
    }

    public function getAllUserOrganisation($id,$req)
    {
        $organisation=$this->getOrganisation($id);
        if($organisation instanceof Organisation){
            $usersOrganisation=$this->organisationRepo->getAllUserOrganisation($organisation,$req);
            return $usersOrganisation;
        }else{
            return null;
        }
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

