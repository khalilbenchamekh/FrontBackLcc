<?php



namespace App\Repository\FeesFolderTech;

use App\Models\FeesFolderTech;

interface IFeesFolderTechRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(FeesFolderTech $feesFolderTech,$request);
    public function destroy($id);
}
