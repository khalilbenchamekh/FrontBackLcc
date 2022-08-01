<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\EmployeeRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Employee;
use App\Models\Linked_Documents;
use App\Models\Role;
use App\Response\Employee\EmployeeResponse;
use App\Services\Employee\IEmployeeService;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    /**
     * @var Employee
     */
    protected $emp;
    public $employeeService;
    public function __construct(IEmployeeService $employeeService)
    {
        $this->employeeService=$employeeService;
//        set_time_limit(8000000);
//
//
//        $this->middleware('role:employees_create|owner|admin', ['only' => ['storeEmployee']]);
//        $this->middleware('role:employees_edit|owner|admin', ['only' => ['update']]);
//        $this->middleware('role:employees_read|owner|admin', ['only' => ['index']]);
//        $this->middleware('role:employees_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index()
    {
        $employees = Employee::with(['user', 'Documents'])
            ->get();
        $i = 0;
        foreach ($employees as $employee) {
            $isOnline = $employee['user']->isOnline();
            $employees[$i]->setAttribute('isOnline', $isOnline);
            $i++;
        }

        return response(['data' => $employees], 200);
    }

    public function storeEmployee(EmployeeRequest $request)
    {

        $employee = new Employee();
        $employee->personal_number = $request->input('personal_number');
        $employee->profession_number = $request->input('profession_number');
        $employee->position_held = $request->input('position_held');
        $employee->linked_documents = $request->hasfile('filenames') ? sizeof($request->file('filenames')) : 0;
        $employee->Start_date = $request->input('Start_date');
        $employee->Salary = $request->input('Salary');
        $employee->save();
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $roleinput = $request->input('role');
        $role = $roleinput == null ? 'user' : $roleinput;
        $roleReq = Role::where('name', '=', $role)->first();

        $user = new User;
        $user->name = "{$firstname} {$middlename} {$lastname}";
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('email'));
        $user->firstname = $firstname;
        $user->middlename = $middlename;
        $user->lastname = $lastname;
        $user->gender = $request->input('gender');
        $user->birthdate = $request->input('birthdate');
        $user->address = $request->input('address');
        $user->membership()->associate($employee);
        $user->save();
        $user->attachRole($roleReq);
        if ($request->hasfile('filenames')) {
            $filesArray = [
                'geoMapping',
                'geoMapping/Employee',
                'geoMapping/Employee/docs',
            ];
            $pathToMove = 'geoMapping/Employee/docs/' . $user->name;
            array_push($filesArray, $pathToMove);
            foreach ($filesArray as $item) {
                $path = public_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }

            foreach ($request->file('filenames') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = md5($filename . time()) . '.' . $extension;
                $path = public_path() . '/' . $pathToMove;
                $file->move($path, $fileNameToStore);
                $docs = new Linked_Documents();
                $docs->name = $fileNameToStore;
                $docs->Employee()->associate($employee);
                $docs->save();
            }
        }
        $subject = LogsEnumConst::Add . LogsEnumConst::Employee . $user->name;
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $user], 201);
    }

    public function download(Request $request)
    {
        $username = $request->input('username');
        $filename = $request->input('filename');
        $file = public_path() . '/' . 'geoMapping/Employee/docs/' . $username . '/' . $filename;
        if (!File::exists($file)) {
            abort(404);
        }

        return response()->download($file, $username);

    }

    public function store(EmployeeRequest $request)
    {
        $employee=$this->employeeService->store($request);
        if ($employee instanceof Employee){
            $response=EmployeeResponse::make($employee);

            dd($response);
        }
//        $employee = Employee::create($request->all());
//
//        return response(['data' => $employee], 201);

    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response(['data', $employee], 200);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $name = "{$firstname} {$middlename} {$lastname}";
        $employee = Employee::findOrFail($id);
        $data = $request->only($employee->getFillable());

        $employee->update($data);
        $subject = LogsEnumConst::Update . LogsEnumConst::Employee . $name;
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $employee], 200);
    }

    public function destroy($id)
    {
        Employee::destroy($id);

        return response(['data' => null], 204);
    }
}
