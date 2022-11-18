<?php
namespace App\Repository\Client;
interface IClientRepository
{
    public function index($request);
    public function business($data);
    public function storeBusiness($data,$bus);
    public function storeParticular($data,$par);
    public function newParticular($data);
    public function store($data);
    public function get($id);
    public function edit($perClient,$data);
    public function delete($id);
    public function editBusiness($data,$particular);
	public function getBusinessById($id);
}
