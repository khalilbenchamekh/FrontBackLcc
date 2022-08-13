<?php

namespace App\Services\AffaireNature;

interface IAffaireNatureService
{
    public function store($request);

    public function getAllAffaireNature($request);

    public function get($id);

    public  function edit($id,$data);

    public  function saveMany($data);

    public function destroy($request);
}
