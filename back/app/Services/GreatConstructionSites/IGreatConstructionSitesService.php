<?php


namespace App\Services\GreatConstructionSites;

interface IGreatConstructionSitesService
{
    public function show($id);
    public function getGreatConstructionSitesBetween($from ,$to);
    public function dashboard($from,$to,$orderBy);
    public function index();
    public function store($request);
    public function storeAllocatedBrigade($request,$greatconstructionsites,$arrayToReturend);
    public function updateAllocatedBrigade($request,$greatconstructionsites,$arrayToReturend);
    public function storeBusinessManagement($ttc,$greatconstructionsites);
    public function destroy($request);
}
