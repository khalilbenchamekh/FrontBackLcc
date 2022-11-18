<?php
namespace App\Repository\BusinessManagement;
interface IBusinessManagementRespositry
{
    public function index($request);
    public function store($request,$affaire = null);
    public function show($id);
    public function update($perElem,$data);
    public function destroy($id);
    public function businessManagement($membership_id,$relation);
}
