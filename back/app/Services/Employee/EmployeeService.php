<?php

namespace App\Services\Employee;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Employee;
use App\Models\Role;
use App\Repository\Employee\IEmployeeRepository;
use App\Services\Admin\IAdminService;
use App\Services\Role\IRoleService;
use App\User;
use Illuminate\Support\Facades\Auth;

class EmployeeService implements IEmployeeService
{
    private $employeeRepository;
    private $adminService;
    private $roleService;
    public function __construct(IEmployeeRepository $employeeRepository,IAdminService $adminService,IRoleService $roleService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }

    public function index($request)
    {
        // TODO: Implement index() method.
        return $this->employeeRepository->index($request);
    }
    public function all()
    {
        // TODO: Implement index() method.
        $employees = $this->employeeRepository->all();
        $i = 0;
        foreach ($employees as $employee) {
            $isOnline = $employee['user']->isOnline();
            $employees[$i]->setAttribute('isOnline', $isOnline);
            $i++;
        }
        return $employees;
    }
    public function create($data){
        $res=$this->employeeRepository->create($data);
        if(!is_null($res)){
            $subject = LogsEnumConst::Add . LogsEnumConst::Employee . $res->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
        }
        return null;
    }
    public function store($data)
    {
        $user=Auth::User();
        $res=$employee= $this->employeeRepository->store($data);
        if($employee instanceof  Employee){
            $user=$this->adminService->createUserToOrganisation($data,$user->organisation);
            if($user instanceof User){
                $roleName = $data->input('role') == null ? 'user' : $data->input('role');
                $filter=[["key"=>"name","value"=>$roleName]];
                $role=$this->roleService->getBy($filter);
                if($role instanceof Role){
                    $user->attachRole($role);
                }
                if(!is_null($res)){
                    $subject = LogsEnumConst::Add . LogsEnumConst::Employee . $user['name'];
                    $logs = new LogActivity();
                    $logs->addToLog($subject, $data);
                }
                return $res;
            }
        }
        return null;
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->employeeRepository->get($id);
    }

    public function edit($id,$data)
    {
        $perEmployee=$this->get($id);
        if($perEmployee){
            $subject = LogsEnumConst::Update . LogsEnumConst::Employee . $data['personal_number'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $data);
            return $this->employeeRepository->edit($perEmployee,$data);
        }
        return null;
    }

    public function delete($request)
    {
        $res= $this->employeeRepository->delete($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Employee . $request['personal_number'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}
