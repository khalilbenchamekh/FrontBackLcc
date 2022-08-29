<?php

namespace App\Services\Employee;

interface IEmployeeService
{
public function index($page);
public function store($data);
public function get($id);
public function edit($id,$data);
public function delete($id);
}
