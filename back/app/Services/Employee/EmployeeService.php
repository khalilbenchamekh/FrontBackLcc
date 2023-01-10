<?php

namespace App\Services\Employee;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Employee;
use App\Models\Role;
use App\Repository\Employee\IEmployeeRepository;
use App\Services\Admin\IAdminService;
use App\Services\Role\IRoleService;
use App\Services\User\IUserService;
use App\User;
use Illuminate\Support\Facades\Auth;

class EmployeeService implements IEmployeeService
{
    private $employeeRepository;
    private $adminService;
    private $roleService;
    private $iUserService;
    public function __construct(IEmployeeRepository $employeeRepository,IAdminService $adminService,IRoleService $roleService,IUserService $iUserService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->adminService = $adminService;
        $this->roleService = $roleService;
        $this->iUserService = $iUserService;
    }

    public function index($request)
    {
        // TODO: Implement index() method.
        return $this->employeeRepository->index($request);
    }
    public function all($request)
    {
        // TODO: Implement index() method.
        $employees = $this->employeeRepository->all($request->all());
        $i = 0;
        foreach ($employees->items() as $employee) {
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
            $currentUser=Auth::user();
            $user=$this->adminService->createUserToOrganisation($data,$currentUser->organisation_id);
            if($user instanceof User){
                $roleName = $data->input('role') == null ? 'user' : $data->input('role');
                $role=$this->roleService->getRoleByName($roleName);
                if($role instanceof Role){
                    $user->attachRole($role);
                }
                $res=$employee= $this->employeeRepository->store($data,$user->id);
                if($employee instanceof  Employee){
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
        $employee= $this->employeeRepository->get($id);
        if(! is_null($employee)){
            $isOnline = $employee['user']->isOnline();
            $employee->setAttribute('isOnline', $isOnline);
        }
        return $employee;
    }

    public function edit($id,$data)
    {
        $newData = ["id"=>$id , "name"=>$data->input("name"),"email"=>$data->input("email")];
        $check = $this->iUserService->checkIfEmailOrNameExist($newData);
        $error = $this->errorMessage($check,$data);
        if(count($error)>0){
            return $error;
        }
        $perEmployee=$this->get($id);
        if($perEmployee){
            $user = $this->iUserService->get($perEmployee->id);
            if(!is_null($user)){
                $subject = LogsEnumConst::Update . LogsEnumConst::Employee . $data['personal_number'];
                $logs = new LogActivity();
                $logs->addToLog($subject, $data);
                return $this->employeeRepository->edit($perEmployee,$user,$data);
            }
        }
        return null;
    }

    private function errorMessage(array $models,$data)
    {
        $messageTable = [];
        $i = 0;
        if(count($models)>0){
            for ($i=0; $i < count($models); $i++) {
                # code...
                $model = $models[$i];
                    if($model ==="name"){
                        array_push($messageTable,'name is exist');
                    }
                    if($model === "email"){
                        array_push($messageTable,'email is exist');
                    }
            }
        }
        return $messageTable;
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

    public function checkIfEmailOrNameExist($request)
    {

    }
}
