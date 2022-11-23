<?php
namespace App\Repository\FolderTechNature;
use App\Models\FolderTechNature;
interface IFolderTechNatureRepository
{
    public function getFolerTechNatureByName($id,$name);
    public function save($request);
    public function index($request,$order=null);
    public function show($id);
    public function update(FolderTechNature $folderTech,$request);
    public function destroy($id);
}
