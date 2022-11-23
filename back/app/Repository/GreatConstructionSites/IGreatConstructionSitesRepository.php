<?php

namespace App\Repository\GreatConstructionSites;

interface IGreatConstructionSitesRepository
{
    public function dashboard($from,$to,$orderBy);
    public function index();
    public function show($id);
    public function getGreatConstructionSitesBetween($from, $to);
    public function destroy($id);
    public function store($request);
    public function storeAllocatedBrigade($arrayToReturend);
    public function storeBusinessManagement($ttc,$greatconstructionsites);
}
