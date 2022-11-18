<?php

namespace App\Services\Client;

interface IClientService
{

    public function index($request);
    public function storeBusiness($data,$bus);
    public function business($data);
    public function storeParticular($data,$par);
    public function newParticular($data);
    public function store($data);
    public function get($id);
    public function edit($perClient,$data);
    public function delete($request);
    public function editBusiness($data,$id);

}
