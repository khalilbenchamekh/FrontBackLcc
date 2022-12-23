<?php
namespace App\Repository\Client;
interface IClientRepository
{
    public function index($request,$order=null);
    public function business($data);
    public function storeBusiness($data,$bus);
    public function storeParticular($data,$par);
    public function newParticular($data);
    public function store($data);
    public function get($id);
    public function edit($perClient,$data);
    public function delete($model);
    public function editBusiness($data,$business);
	public function getBusinessById($id);
}
