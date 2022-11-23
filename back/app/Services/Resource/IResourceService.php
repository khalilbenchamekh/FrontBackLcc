<?php

namespace App\Service\Resource;


interface IResourceService
{
    public function getLocations();
    public function getUser($request);
    public function getCountDown();
    public function getLocationsAutoComplete($request,$order=null);
    public function getAllocatedBrigades($request,$order=null);
    public function getSearch($request);
    public function getSearchWithDetails($request);
}


