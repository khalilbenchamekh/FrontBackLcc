<?php

namespace App\Repository\Resource;

use App\Http\Resources\GetFess;

interface IResourceRepository
{
    public function getLocationsAutoComplete($request,$order=null);
    public function getAllocatedBrigades($request,$order=null);
    public function getFess(GetFess $fess);
    public function getDetails(GetFess $fess, $id);
}


