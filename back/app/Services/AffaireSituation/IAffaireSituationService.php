<?php

namespace App\Services\AffaireSituation;

interface IAffaireSituationService
{
public function index($request,$order=null);
public function get($id);
public function edit($perAffaireSituation,$data);
public function delete($request);
public function store($data);
public function storeMany($data);
}
