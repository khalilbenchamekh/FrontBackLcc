<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\EmployeeRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Employee;
use App\Response\Employee\EmployeeResponse;
use App\Response\Employee\EmployeesResponse;
use App\Services\Employee\IEmployeeService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;
class EmployeeController extends Controller
{
    /**
     * @var Employee
     */
    protected $emp;
    public $employeeService;
    private $saveFileService;

    public function __construct(IEmployeeService $employeeService,ISaveFileService $saveFileService)
    {
        $this->saveFileService = $saveFileService;

        $this->employeeService=$employeeService;
        set_time_limit(8000000);
        $this->middleware('role:employees_create|owner|admin', ['only' => ['storeEmployee']]);
        $this->middleware('role:employees_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:employees_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:employees_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index()
    {
        $res=$this->employeeService->all();
        if($res instanceof LengthAwarePaginator){
            $response =  EmployeesResponse::make($res->items());
            return response()->json(
            [
                "data"=>$response,
                'countPage'=>$res->perPage(),
                "currentPage"=>$res->currentPage(),
                "nextPage"=>$res->currentPage()<$res->lastPage()?$res->currentPage()+1:$res->currentPage(),
                "lastPage"=>$res->lastPage(),
                'total'=>$res->total(),
            ],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function storeEmployee(EmployeeRequest $request)
    {
        $res=$this->employeeService->create($request->all());
        if(!is_null($res) ){
            $path = 'Employee/docs/' . $res->name;
            $this->saveFileService->saveEmployeeFiles($res,$path,$request->file('filenames'));
           $response=EmployeeResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function download(Request $request)
    {
        $username = $request->input('username');
        $filename = $request->input('filename');
        $path = 'Employee/docs/' . $username . '/' . $filename;
        $file = $this->saveFileService->downloadFile($path);
        return response()->download($file, $username);
    }

    public function store(EmployeeRequest $request)
    {
        $employee=$this->employeeService->store($request->all());
        if ($employee instanceof Employee){
            $response=EmployeeResponse::make($employee);
           return response()->json($response,Response::HTTP_CREATED);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $client= $this->employeeService->get($id);
        if (!is_null($client)) {
            $response = EmployeeResponse::make($client);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
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

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "personal_number"=>["required","string"]
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->employeeService->delete($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
