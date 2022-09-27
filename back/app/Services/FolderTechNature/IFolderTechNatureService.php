<?php


namespace App\Services\FolderTechNature;



use Illuminate\Http\Request;

interface IFolderTechNatureService
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($id,$request);
    public function destroy($id);
    public function storeMany(Request $request);
}
