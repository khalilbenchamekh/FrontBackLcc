<?php

namespace App\Services\AffaireNature;

interface IAffaireNatureService
{
    public function store($request);

    public function getAllAffaireNature($id,$request);

    public function checkIfOrganisationExist($id):bool;

    public function get($id,$data);

    public  function edit($id,$data);

    public  function saveMany($data);

    public function destroy($id);
}
