<?php

namespace App\Services\AffaireSituation;

interface IAffaireSituationService
{
public function index($page);
public function get($id);
public function edit($perAffaireSituation,$data);
public function delete($perAffaireSitution,$id);
public function store($data);
public function storeMany($data);
}
