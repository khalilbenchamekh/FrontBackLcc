<?php
namespace App\Repository\Employee;
interface IEmployeeRepository
{
    public function all();
    public function index($request);
    public function store($data);
    public function get($id);
    public function edit($perEmployee,$data);
    public function delete($id);
    public function create($data);
}
