<?php

namespace App\Services\Employee;

interface IEmployeeService
{
public function index($request);
public function all($request);
public function store($data);
public function get($id);
public function edit($id,$data);
public function delete($id);
public function create($data);

}
