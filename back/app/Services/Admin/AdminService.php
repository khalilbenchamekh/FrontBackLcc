<?php

namespace App\Services\Admin;

use App\Repository\Admin\IAdminRepository;
use App\Services\Organisation\IOrganisationService;
use App\Services\SaveFile\ISaveFileService;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminService implements IAdminService
{
    public $adminRepository;
    public $organisationService;
    private $iSaveFileService;

    public function __construct(ISaveFileService $iSaveFileService,IAdminRepository $adminRepository,IOrganisationService $organisationService)
    {
        $this->adminRepository=$adminRepository;
        $this->organisationService=$organisationService;
        $this->iSaveFileService=$iSaveFileService;
    }

    public function getAllUser($data)
    {
        try {
            return $this->adminRepository->getAllUser($data['limit'],$data['page']);
        }catch (\Exception $exception){
            return  null;
        }

    }

    public  function getUserCount():?int
    {
        try {
            $count = $this->adminRepository->getUserCount();
            return $count;
        }catch (\Exception $exception){
            return null;
        }
    }
    public  function getUser($id)
    {
        try {
            return $this->adminRepository->getByUser($id);
        }catch (\Exception $exception){
            return null;
        }
    }
    public function createUserToOrganisation($request,$organisation_id)
    {
        return $this->adminRepository->createUserToOrganisation($request,$organisation_id);
    }
    public function createUser($request)
    {
        if(!isset($request)) return  null;
        try {
            $user = $this->adminRepository->createUser($request);
           return $user;
        }catch (\Exception $exception){
            return null;
        }
    }
    public function editUser($request,$id)
    {
        $user= $this->getUser($id);
        if ($user instanceof  User){
            return $this->adminRepository->editUser($user,$request);
        }else{
            return null;
        }

    }
    public function deleteUser($id)
    {
        $user= $this->getUser($id);
        if(!($user instanceof User)) return null;
        $deletedUser= $this->adminRepository->deleteUser($user);
           if($deletedUser instanceof User){
               return  $deletedUser;
           }else{
               return null;
           }
    }
    public function enableUser($id)
    {
        $user= $this->getUser($id);
        if($user instanceof User){
            if($user->activer === 0 || $user->activer === 1|| $user->activer === null){
                return $this->adminRepository->enable($user);
            }else{
                return $user;
            }
        }else{
            return  null;
        }
    }
    public function disableUser($id)
    {
        $user= $this->getUser($id);
        if($user instanceof User){
            if($user->desactiver === 0 || $user->desactiver === 1 || $user->desactiver === null){
                return $this->adminRepository->disable($user);
            }else{
                return $user;
            }
        }else{
            return  null;
        }
    }
    public function generatePassword($id,$newPassword)
    {
        $newPassword=Hash::make($newPassword);
        $user =$this->getUser($id);
        if($user instanceof User){
            return $this->adminRepository->generatePassword($user,$newPassword);
        }else{
            return null;
        }
    }
    public function block($id)
    {
        $user=$this->getUser($id);
        if($user instanceof User){
            if($user->blocked===0){
                return $this->adminRepository->block($user,1);
            }else{
                return $this->adminRepository->block($user,0);
            }
        }else{
            return  null;
        }
    }
    public function addIdOrganisationToCto($cto,$organisation_id)
    {
        if($cto instanceof  User){
            return $this->adminRepository->addIdToCto($cto,$organisation_id);
        }else{
            return null;
        }
    }
    public function getAllUserOrganisationToEmail($organisation_id,$cto_id)
    {
       return $this->adminRepository->getAllUserOrganisationToEmail($organisation_id,$cto_id);
    }

    public function saveImageUser($id, $request, $base64)
    {
        $user=$this->getUser($id);
        if (!is_null($user)) {
            $org = $this->organisationService->getOrganisation($user->organisation_id);
            if (!is_null($org)) {
                $fileName = $base64===false ?  $this->iSaveFileService->store_image($org->name.'/'.$user->name, $request,$user->filename):
                $this->iSaveFileService->store_image_if_is_it_base64($org->name.'/'.$user->name, $request,$user->filename);
                $res = $this->adminRepository->saveImage($user, $fileName);
                if (!is_null($res)) {
                    return $res;
                }
            }
        }
        return null;
    }

    public function getImageUser($id)
    {
        $res= $this->getUser($id);
        if(!is_null($res)){
            $org= $this->organisationService->getOrganisation($res->organisation_id);
            $defaultImage= $res->filename != null ? $res->filename  : "Default.jpg";
            return $this->iSaveFileService->fetchImage($org->name.'/'. $res->name,$defaultImage);
        }
        return null;
    }
}
