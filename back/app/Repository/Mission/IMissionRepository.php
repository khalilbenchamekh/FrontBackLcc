<?php


namespace App\Repository\Mission;


use App\Models\Mission;

interface IMissionRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update(Mission $folderTech,$request);
    public function destroy($id);
}
