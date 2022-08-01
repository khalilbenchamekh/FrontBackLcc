<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\Role;
use App\Repository\Employee\IEmployeeRepository;
use App\Services\AdminService;
use App\Services\Role\IRoleService;
use App\User;

class EmployeeService implements IEmployeeService
{
    private $employeeRepository;
    private $adminService;
    private $roleService;
    public function __construct(IEmployeeRepository $employeeRepository,AdminService $adminService,IRoleService $roleService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }

    public function index($page)
    {
        // TODO: Implement index() method.
        return $this->employeeRepository->index($page);
    }

    public function store($data)
    {
        $roleName = $data->input('role') == null ? 'user' : $data->input('role');
        $filter=[["key"=>"name","value"=>$roleName]];
        $role=$this->roleService->getBy($filter);
        dd($role);
        if($role instanceof Role){
            $user->attachRole($role);
        }
        // TODO: Implement store() method.
        $organisation_id=3;
        $employee= $this->employeeRepository->store($data);
        if($employee instanceof  Employee){
            $user=$this->adminService->createUserToOrganisation($data,$organisation_id);
            if($user instanceof User){
                $roleName = $data->input('role') == null ? 'user' : $data->input('role');
                $filter=[["key"=>"name","value"=>$roleName]];
                $role=$this->roleService->getBy($filter);
                dd($role);
                if($role instanceof Role){
                    $user->attachRole($role);
                }
                return $employee;
            }
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->employeeRepository->get($id);
    }

    public function edit($perEmployee, $data)
    {
        // TODO: Implement edit() method.
        return $this->employeeRepository->edit($perEmployee, $data);
    }

    public function delete($perEmployee, $id)
    {
        // TODO: Implement delete() method.
        return $this->employeeRepository->delete($perEmployee, $id);
    }
}
