<?php

namespace App\Services\Employee;

interface IEmployeeService
{
public function index($page);
public function store($data);
public function get($id);
public function edit($perEmployee,$data);
public function delete($perEmployee,$id);
}
