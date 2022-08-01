<?php

namespace App\Repository\Employee;

use App\Models\Employee;
use App\Repository\Log\LogTrait;

class EmployeeRepository implements IEmployeeRepository
{
    use LogTrait;
    public function index($page)
    {
        // TODO: Implement index() method.
    }

    public function store($data)
    {
        $organisation_id=3;
        // TODO: Implement store() method.
        try {
            $employee = new Employee();
            $employee->personal_number = $data->input('personal_number');
            $employee->organisation_id = $organisation_id;
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
        // TODO: Implement get() method.
    }

    public function edit($perEmployee, $data)
    {
        // TODO: Implement edit() method.
    }

    public function delete($perEmployee, $id)
    {
        // TODO: Implement delete() method.
    }
}
