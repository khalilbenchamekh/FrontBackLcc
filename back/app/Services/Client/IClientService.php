<?php

namespace App\Services\Client;

interface IClientService
{

    public function index($page);
    public function storeBusiness($data,$bus);
    public function storeParticular($data,$par);
    public function store($data);
    public function get($id);
    public function edit($perClient,$data);
    public function delete($perClient,$id);

}
