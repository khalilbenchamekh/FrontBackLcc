<?php

namespace App\Repository\AffaireSituation;

interface IAffaireSituationRepository
{
    public function index($request);
    public function get($id);
    public function edit($perAffaireSituation,$data);
    public function delete($request);
    public function store($data);
    public function storeMany($data);
}
