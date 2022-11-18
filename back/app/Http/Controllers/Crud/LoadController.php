<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\LoadRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\fileLoad;
use App\Models\Load;
use App\Response\Load\LoadResponse;
use App\Response\Load\LoadsResponse;
use App\Services\FileLoad\IFileLoadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\Load\ILoadService;
use App\Services\SaveFile\ISaveFileService;
use Symfony\Component\HttpFoundation\Response;

class LoadController extends Controller
{

    public $loadService;
    private $saveFileService;
    private $fileLoadService;
    public function __construct(ILoadService $loadService,ISaveFileService $saveFileService,IFileLoadService $fileLoadService)
    {
        $this->fileLoadService=$fileLoadService;
        $this->saveFileService=$saveFileService;
        $this->loadService=$loadService;
        set_time_limit(8000000);
         $this->middleware('role:loads_create|owner|admin', ['only' => ['store']]);
         $this->middleware('role:loads_edit|owner|admin', ['only' => ['update']]);
         $this->middleware('role:loads_read|owner|admin', ['only' => ['index']]);
         $this->middleware('role:loads_delete|owner|admin', ['only' => ['destroy']]);
    }
    public function dashboard(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        if (!empty($from) || !empty($to)) {

            $validator = Validator::make($request->all(), [
                'from' => 'date_format:Y/m/d',
                'to' => 'date_format:Y/m/d',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),Response::HTTP_BAD_REQUEST);
            }
        } else {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }

        if (!empty($orderBy)) {
            $validator = Validator::make($request->all(), [
                'orderBy' => 'in:year,month',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),Response::HTTP_BAD_REQUEST);
            }
        } else {
            $orderBy = 'year';
        }
        $byDateAffChoice = $this->loadService->dashboard($from,$to,$orderBy);
        return response(['data' => $byDateAffChoice],Response::HTTP_OK);
    }
    public function index(PaginationRequest $request)
    {
        $res = $this->loadService->index($request);
        if($res instanceof LengthAwarePaginator){
            $response = LoadsResponse::make($res->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function store(LoadRequest $request)
    {
        $load= $this->loadService->store($request->all());
        if($load instanceof  Load){
            if($request->hasFile("filenames")){
                $ref =$request->input('REF');
                $files=$request->file("filenames");
                $direction='Loads/'.$ref;
                $saveFile=$this->saveFileService->saveFiles($direction,$files);
                if (isset($saveFile)){
                    $data= [
                      "filename"=>$saveFile,
                      "load_id"=>$load->id,
                    ];
                    $fileLoad=$this->fileLoadService->store($data);
                    if($fileLoad instanceof fileLoad){
                        $subject = LogsEnumConst::Update . LogsEnumConst::Load . $ref;
                        $logs = new LogActivity();
                        $logs->addToLog($subject, $request);
                    }
                }
                $response=LoadResponse::make($load);
                return \response()->json(["data"=>$response],Response::HTTP_CREATED);
            }

        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $load = $this->loadService->show($id);
        if($load instanceof  Load){
            $response = LoadResponse::make($load);
            return  response()->json(['data'=>$response],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'load_related_to' => 'exists:users,id',
            'load_types_name' => 'exists:load_types,name',
            'TVA' => 'in:20,14,10',
            'DATE_LOAD' => 'date',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(),Response::HTTP_BAD_REQUEST);
        }

        $load=$this->loadService->show($id);
        $file=$this->fileLoadService->getLoadId($id);
        if($load instanceof  Load){
            if ( $file instanceof  fileLoad){
                if($request->hasFiles("filenames")){
                    $direction=$file->filename;
                    $folder="Loads/";
                    $fileLoad=$this->saveFileService->editFile($direction,$request->file("filenames"),$folder);
                    if(isset($fileLoad)){
                        $data= [
                            "filename"=>$fileLoad,
                            "load_id"=>$load->id,
                        ];
                        $fileLoad=$this->fileLoadService->edit($file,$data);
                        if($fileLoad instanceof fileLoad){
                            $subject = LogsEnumConst::Update . LogsEnumConst::Load . $load->ref;
                            $logs = new LogActivity();
                            $logs->addToLog($subject, $request);
                        }
                    }
                }
            }
            $newLoad= $this->loadService->edit($load,$request->all());
            if ($newLoad instanceof  Load){
                $response=  LoadResponse::make($newLoad);
                return  response()->json(['data'=>$response],Response::HTTP_OK);
            }
        }

    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "REF"=>["required","string"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->loadService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
