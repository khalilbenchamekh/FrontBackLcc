<?php

namespace App\Services\Email;

use App\Http\Requests\Enums\EmailMessageChoice;
use App\Mail\Email;
use App\Organisation;
use App\Services\Admin\IAdminService;
use App\Services\Organisation\IOrganisationService;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ISendEmail
{
    private $organisationService;
    private $adminService;
    public function __construct(IOrganisationService $organisationService,IAdminService $adminService)
    {
        $this->organisationService=$organisationService;
        $this->adminService=$adminService;
    }

    public function send($user ,string $action)
    {
        $messageOrganisation =["Organisation created","Organisation edited","Organisation deleted", "Organisation enabled" ,"Organisation disabled","Organisation blocked"];
        $messageUser =["User created","User edited","User deleted", "User enabled" ,"User disabled","User blocked","Generate Password To User"];
        switch ($action){
            case EmailMessageChoice::CREATE_ORGANISATION :
               $organisation=$this->organisationService->getOrganisationByCto($user->id);
                $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
               $this->email($to,$messageOrganisation[0]);
                 return true;
            case EmailMessageChoice::EDITE_ORGANISATION:
                $usersOrganisation=$this->adminService->getAllUserOrganisationToEmail($user->organisation_id,$user->id);
                $organisation=$this->organisationService->getOrganisationByCto($user->id);
                $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
                if(count($usersOrganisation)>0){
                    for ($i=0;$i<count($usersOrganisation);$i++){
                        $el=$usersOrganisation[$i];
                        array_push($to,$el->email);
                    }
                    $this->email($to,$messageOrganisation[1]);
                }

                return true;
            case EmailMessageChoice::DELETE_ORGANISATION:
                $usersOrganisation=$this->adminService->getAllUserOrganisationToEmail($user->organisation_id,$user->id);
                $organisation=$this->organisationService->getOrganisationByCto($user->id);
                    $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
                    if(count($usersOrganisation)>0){
                        for ($i=0;$i<count($usersOrganisation);$i++){
                            $el=$usersOrganisation[$i];
                            array_push($to,$el->email);
                        }
                    }
                    $this->email($to,$messageOrganisation[2]);
                return true;
            case EmailMessageChoice::ENABLE_ORGANISATION:
                $usersOrganisation=$this->adminService->getAllUserOrganisationToEmail($user->organisation_id,$user->id);
                $organisation=$this->organisationService->getOrganisationByCto($user->id);
                $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
                if(count($usersOrganisation)>0){
                    for ($i=0;$i<count($usersOrganisation);$i++){
                        $el=$usersOrganisation[$i];
                        array_push($to,$el->email);
                    }
                }
                $this->email($to,$messageOrganisation[3]);
                return true;
            case EmailMessageChoice::DISABLE_ORGANISATION:
                $usersOrganisation=$this->adminService->getAllUserOrganisationToEmail($user->organisation_id,$user->id);
                $organisation=$this->organisationService->getOrganisationByCto($user->id);
                $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
                if(count($usersOrganisation)>0){
                    for ($i=0;$i<count($usersOrganisation);$i++){
                        $el=$usersOrganisation[$i];
                        array_push($to,$el->email);
                    }
                }
                $this->email($to,$messageOrganisation[4]);
                return true;
            case EmailMessageChoice::BLOCK_ORGANISATION:
                $usersOrganisation=$this->adminService->getAllUserOrganisationToEmail($user->organisation_id,$user->id);
                $organisation=$this->organisationService->getOrganisationByCto($user->id);
                $to=[$user?$user->email:null,$organisation?$organisation->emailOrganisation:null];
                if(count($usersOrganisation)>0){
                    for ($i=0;$i<count($usersOrganisation);$i++){
                        $el=$usersOrganisation[$i];
                        array_push($to,$el->email);
                    }
                }
                $this->email($to,$messageOrganisation[5]);
                return true;
            case EmailMessageChoice::CREATE_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[0]);
                    return true;
                }
                return true;
            case EmailMessageChoice::EDIT_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[1]);
                    return true;
                }
                break;
            case EmailMessageChoice::DELETE_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[2]);
                    return true;
                }
                break;
            case EmailMessageChoice::ENABLE_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[3]);
                    return true;
                }
                break;
            case EmailMessageChoice::DISABLE_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[4]);
                    return true;
                }
                break;
            case EmailMessageChoice::BLOCK_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[5]);
                    return true;
                }
                break;
            case EmailMessageChoice::GENERATE_PASSWORD_TO_USER:
                if(isset($user)){
                    $organisation=$this->organisationService->getOrganisation($user->organisation_id);
                    $cto=$this->adminService->getUser($organisation->cto);
                    $to=[$cto?$cto->email:null,$organisation?$organisation->emailOrganisation:null,$user->email];
                    $this->email($to,$messageUser[6]);
                    return true;
                }
                break;
            default:
                return false;
        }

    }
    public function email($to,$message)
    {
        for ($i=0;$i<count($to);$i++){
            $el=$to[$i];
            if(isset($el)){
                Mail::to($el)->send(new Email($message));
            }
        }
    }

    public function ResetPassword($to,$message){
        Mail::to($to)->send(new Email($message));
    }
}
