<?php
namespace App\Repository\Employee;
use App\Models\Employee;
use App\Models\Linked_Documents;
use App\Models\Role;
use App\Repository\Log\LogTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class EmployeeRepository implements IEmployeeRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function index($data)
    {
        // TODO: Implement index() method.
        try{
            $employees=Employee::with(['user', 'Documents'])
            ->where('organisation_id','=',$this->organisation_id)
            ->paginate($data['limit'],['*'],'page',$data['page']);
            return $employees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }public function all()
    {
        try{
            $employees=Employee::with(['user', 'Documents'])
            ->where('organisation_id','=',$this->organisation_id)
            ->get;
            return $employees;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        // TODO: Implement store() method.
        try {
            $employee = new Employee();
            $employee->personal_number = $data->input('personal_number');
            $employee->organisation_id = $this->organisation_id;;
            $employee->profession_number = $data->input('profession_number');
            $employee->position_held = $data->input('position_held');
            $employee->linked_documents = $data->hasfile('filenames') ? sizeof($data->file('filenames')) : 0;
            $employee->Start_date = date("Y-m-d H:i:s",strtotime($data->input('Start_date')));
            $employee->Salary = $data->input('Salary');
            $employee->save();
            return  $employee;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function create($data)
    {
        // TODO: Implement store() method.
        try {
            $employee = new Employee();
        $employee->personal_number = $data->input('personal_number');
        $employee->profession_number = $data->input('profession_number');
        $employee->position_held = $data->input('position_held');
        $employee->linked_documents = $data->hasfile('filenames') ? sizeof($data->file('filenames')) : 0;
        $employee->Start_date = $data->input('Start_date');
        $employee->Salary = $data->input('Salary');
        $employee->save();
        $firstname = $data->input('firstname');
        $middlename = $data->input('middlename');
        $lastname = $data->input('lastname');
        $roleinput = $data->input('role');
        $role = $roleinput == null ? 'user' : $roleinput;
        $roleReq = Role::where('name', '=', $role)->first();

        $user = new User;
        $user->name = "{$firstname} {$middlename} {$lastname}";
        $user->username = $data->input('username');
        $user->email = $data->input('email');
        $user->password = Hash::make($data->input('email'));
        $user->firstname = $firstname;
        $user->middlename = $middlename;
        $user->lastname = $lastname;
        $user->gender = $data->input('gender');
        $user->birthdate = $data->input('birthdate');
        $user->address = $data->input('address');
        $user->membership()->associate($employee);
        $user->save();
        $user->attachRole($roleReq);
        return $user;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        try {
            $employee = Employee::findOrFail($id)->where('organisation_id','=',$this->organisation_id);
            return  $employee;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($perEmployee, $data)
    {
        try{
            $perEmployee->update($data->all());
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function delete($id)
    {
        try{
            return  Employee::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
