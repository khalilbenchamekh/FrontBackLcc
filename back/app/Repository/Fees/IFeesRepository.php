<?php
namespace App\Repository\Fees;
interface IFeesRepository
{
    public function index($request);
    public function getBusinessFees($request);
    public function saveBusinessFees($busines_mang,$request);
     public function saveFolderTechFees($busines_mang,$request);
    public function show($id);
    public function updateBusinessFees($fees,$request,$busines_mang_id);
    public function updateFolderTechFees($fees,$request,$busines_mang_id);
    public function destroy($request);
    public function getFolderTechFees($request);
    public function saveGreatConstructionSitesFees($greatConstructionSites_id,$request);
}
