<?php

namespace App\Repository\Employee;

interface IEmployeeRepository
{
    public function index($page);
    public function store($data);
    public function get($id);
    public function edit($perEmployee,$data);
    public function delete($perEmployee,$id);
}
