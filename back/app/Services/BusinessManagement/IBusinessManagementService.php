<?php

namespace App\Services\BusinessManagement;

interface IBusinessManagementService
{
    public function index($request);
    public function store($data);
    public function get($id);
    public function edit($id,$data);
    public function delete($request);
}
