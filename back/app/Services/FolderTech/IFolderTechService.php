<?php


namespace App\Services\FolderTech;

use App\Models\FolderTech;

interface IFolderTechService
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function delete($request);
    public function getFolderTech($request);
    public function saveBusinessManagement($request,$affaire);
    public function saveMission($request,$affaire);
    public function getFolderTechBetween($from ,$to);
}
