<?php


namespace App\Services\FolderTechSituation;

use Illuminate\Http\Request;

interface IFolderTechSituationService
{
    public function storeMany(Request $request);
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
}
