<?php
namespace App\Repository\Mission;
interface IMissionRepository
{
    public function save($request);
    public function index($request);
    public function show($id);
    public function update($data,$id);
    public function destroy($id);
    public function getMissionOfUSer($userID);
}
