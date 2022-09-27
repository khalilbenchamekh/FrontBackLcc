<?php


namespace App\Repository\BusinessManagement;


interface IBusinessManagementRespositry
{
    public function index($request);
    public function store($request);
    public function show($id);
    public function update($perElem,$data);
    public function destroy($id);
}
