<?php
namespace App\Repository\FolderTech;
use App\Models\FolderTech;
interface IFolderTechRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(FolderTech $folderTech,$request);
    public function destroy($id);
    public function getFolderTech($request);
    public function saveBusinessManagement($request,$affaire);
    public function saveMission($request,$affaire);
    public function getFolderTechBetween($from, $to);
}
