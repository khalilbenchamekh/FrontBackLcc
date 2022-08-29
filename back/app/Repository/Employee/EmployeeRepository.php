<?php

namespace App\Repository\Employee;

use App\Models\Employee;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class EmployeeRepository implements IEmployeeRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
    }



    public function index($request)
    {
        // TODO: Implement index() method.
        try{
            $employees=Employee::with(['user', 'Documents'])
            ->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
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
