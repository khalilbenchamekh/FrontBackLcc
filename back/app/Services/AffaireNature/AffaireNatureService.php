<?php

namespace App\Services\AffaireNature;

use App\Models\AffaireNature;
use App\Organisation;
use App\Repository\AffaireNature\IAffaireNatureRepository;
use App\Services\OrganisationService;

class AffaireNatureService implements IAffaireNatureService
{
    private $affaireNatureRepository;
    private $organisationService;
    public function __construct(IAffaireNatureRepository $affaireNatureRepository,OrganisationService $organisationService)
    {
        $this->affaireNatureRepository=$affaireNatureRepository;
        $this->organisationService=$organisationService;
    }

    public function store($request)
    {
        $org=$this->checkIfOrganisationExist($request->input('organisation_id'));
        $chckIfExist=$this->affaireNatureRepository->findAffaireNatureByName($request->input('Name'));
        if(count($chckIfExist->toArray())>0){
            return true;
        }
        if($org){
            return $this->affaireNatureRepository->store($request->all());
        }else{
            return null;
        }
    }
    public function checkIfOrganisationExist($id):bool
    {
        $org=$this->organisationService->getOrganisation($id);
        if($org instanceof Organisation){
            return true;
        }else{
            return  false;
        }
    }
    public function getAllAffaireNature($id,$request)
    {
        $org=$this->checkIfOrganisationExist($id);
        if($org){
            return $this->affaireNatureRepository->getAllAffaireNature($id,$request);
        }else{
            return  null;
        }
    }

    public function get($id, $data)
    {
        // TODO: Implement get() method.
        $org=$this->checkIfOrganisationExist($data['organisation_id']);
        if($org){
            return $this->affaireNatureRepository->get($id,$data);
        }else{
            return null;
        }
    }

    public function edit($id, $data)
    {
        // TODO: Implement edit() method.
        $org=$this->checkIfOrganisationExist($data['organisation_id']);
        if($org){
            $chckIfExist=$this->affaireNatureRepository->findAffaireNatureByName($data['Name']);
            if(count($chckIfExist->toArray())>0){
                return true;
            }
            $affairNature=$this->get($id,$data);
            if($affairNature){
                $newAffaireNature=$this->affaireNatureRepository->edit($affairNature,$data);
                return $newAffaireNature;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function saveMany($data)
    {
       return  $this->affaireNatureRepository->saveMany($data);
    }

    public function destroy($id)
    {
        $affaire=AffaireNature::find($id);
        if($affaire instanceof AffaireNature){
            return $this->affaireNatureRepository->destroy($id);
        }else{
            return null;
        }
    }
}
