<?php

namespace App\Repository\AffaireNature;

interface IAffaireNatureRepository
{
    public function store($data);
    public function findAffaireNatureByName($id);

    public function getAllAffaireNature($id,$request);

    public function get($id,$data);

    public  function edit($affairNature,$data);

    public  function saveMany($data);

    public function destroy($id);
}
