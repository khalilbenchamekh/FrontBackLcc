<?php
namespace App\Repository\Employee;
interface IEmployeeRepository
{
    public function all($request);
    public function index($request);
    public function store($data,$user_id);
    public function get($id);
    public function edit($perEmployee,$user,$data);
    public function delete($id);
    public function create($data);
}
