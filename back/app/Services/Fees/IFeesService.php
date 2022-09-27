<?php

namespace App\Services\Fees;



interface IFeesService
{
    public function index($request);
    public function saveBusinessFees($request);
    public function show();
    public function saveFolderTechFees($request);
    public function updateBusinessFees($request,$id);
    public function destroy();
    public function getBusinessFees($request);
    public function getFolderTechFees($request);
}

