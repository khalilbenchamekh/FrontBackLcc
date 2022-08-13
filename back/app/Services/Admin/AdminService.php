<?php

namespace App\Services\Admin;

use App\Organisation;
use App\Repository\Admin\IAdminService;
use App\Services\Organisation\IOrganisationService;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public $adminRepository;
    public $organisationService;
    public function __construct(IAdminService $adminRepository,IOrganisationService $organisationService)
    {
        $this->adminRepository=$adminRepository;
        $this->organisationService=$organisationService;
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
        if($user == null) return null;
        $org = $this->organisationService->getOrganisation($user->organisation_id);
        if ($org instanceof Organisation && $user instanceof User) {
            $store = new ImageService();
            $filesArray = [
                'geoMapping',
                'geoMapping/organisation/' . $org->name.'/'.$user->name,
            ];
            if($base64===false){
                $fileName = $store->store_image($filesArray, $request, "/" . $filesArray[1],$user->filename);
                if (isset($fileName)) {
                    $user = $this->adminRepository->saveImage($user, $fileName);
                    if ($user instanceof User) {
                        return $user;
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            }
            if ($base64 ===true){
                $fileName = $store->store_image_if_is_it_base64($filesArray, $request, "/" . $filesArray[1],$user->filename);
                if (isset($fileName)) {
                    $user = $this->adminRepository->saveImage($user, $fileName);
                    if ($user instanceof User) {
                        return $user;
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

    public function getImageUser($id)
    {
        $user=$this->getUser($id);
        if($user == null) return null;
        $org= $this->organisationService->getOrganisation($user->organisation_id);
        $path = 'geoMapping/organisation/' . $org->name.'/'.$user->name;
        if($org instanceof  Organisation && $user instanceof User && $user->filename != null){
            $image = new ImageService();
            return $image->fetchImage($path,$user->filename);
        }
        // IF USER DON'T HAVE ANY IMAGE THEN WE RETURN DEFAULT IMAGE
        $defaultImage="Default.jpg";
        $path='geoMapping/organisation';
        if($org instanceof  Organisation && $user instanceof User && $user->filename === null){
            $image = new ImageService();
            return $image->fetchImage($path,$defaultImage);
        }
    }
}
