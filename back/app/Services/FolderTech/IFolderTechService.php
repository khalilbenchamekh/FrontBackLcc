<?php


namespace App\Services\FolderTech;

use App\Models\FolderTech;

interface IFolderTechService
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
    public function getFolderTech($request);
}
