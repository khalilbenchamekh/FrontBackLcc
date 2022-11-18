<?php
namespace App\Repository\FolderTechSituation;
use App\Models\FolderTechSituation;
interface IFolderTechSituationRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(FolderTechSituation $folderTech,$request);
    public function destroy($folderTechSituation);
}
