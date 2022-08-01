<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\File;
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
        // set_time_limit(8000000);
        // $this->middleware('role:loads_create|owner|admin', ['only' => ['store']]);
        // $this->middleware('role:loads_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:loads_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:loads_delete|owner|admin', ['only' => ['destroy']]);
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
                return response($validator->errors(), 400);
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
                return response($validator->errors(), 400);
            }
        } else {
            $orderBy = 'year';
        }


        $byDateAffChoice = DB::table('loads as g')
            ->whereBetween('g.DATE_LOAD', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`g`.`DATE_LOAD`) as `year`")
                    : DB::raw("MONTH(`g`.`DATE_LOAD`) as `month`")
                ,
                DB::raw(" (SELECT count(`g`.`DATE_LOAD`) FROM `loads` as `g`  ) as `charges`  ")
            )
            ->groupBy([$orderBy])
            ->get()
            ->reverse();
        $charges = [];
        $gropBy = [];
        for ($i = 0; $i < sizeof($byDateAffChoice); $i++) {
            $item = $byDateAffChoice[$i];
            array_push($charges, $item->charges);
            array_push($gropBy, $item->$orderBy);
        }
        $series = [
            [
                "name" => "charges",
                "data" => $charges,
            ]
        ];
        $data = [
            "series" => $series,
            "categories" => array_unique($gropBy)
        ];
        return response(['data' => $data], 200);


    }

    public function index(Request $request)
    {
        $validator=Validator::make($request->all(),[
           "page"=>"required|integer"
        ]);
        if($validator->fails()){
             return \response()->json(['error'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        $page=$request->input('page');
        $loads=$this->loadService->index($page);
        if($loads instanceof  LengthAwarePaginator){
            $response=LoadsResponse::make($loads);
            return response()->json([
                "loads"=>$response,
                'total'=>$loads->total(),
                'lastPage'=>$loads->lastPage(),
                'currentPage'=>$loads->currentPage()
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
    }

    public function store(LoadRequest $request)
    {

// DANS CETTE METHODE ET DANS LE CAS DE SAVEFILE ON PEUT JUST EBREGISTRER UN SEUL FICHER


        $load= $this->loadService->store($request->all());
        if($load instanceof  Load){
            if($request->hasFile("filenames")){
                $ref =$request->input('REF');
                $files=$request->file("filenames");
                $direction='Loads/'.$ref;
                $saveFile=$this->saveFileService->saveFile($direction,$files);
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
                return \response()->json(["load"=>$response],\Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
            }

        }
        return response()->json(["error"=>"Bad Request"],\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);



        // $amount = $request->input('amount');
        // $ref = $request->input('REF');
        // $load_related_to = $request->input('load_related_to');
        // $load_types_name = $request->input('load_types_name');
        // $tva = $request->input('TVA');
        // $date = $request->input('DATE_LOAD');
        // $load = new Load();
        // $load->amount = $amount;
        // $load->REF = $ref;
        // $load->load_related_to = $load_related_to;
        // $load->load_types_name = $load_types_name;
        // $load->TVA = $tva;
        // $load->DATE_LOAD = $date;
        // $load->save();        // if ($request->hasfile('filenames')) {

        //     $filesArray = [
        //         'geoMapping',
        //         'geoMapping/Load',
        //     ];
        //     $pathToMove = 'geoMapping/Load/' . $ref;
        //     array_push($filesArray, $pathToMove);
        //     foreach ($filesArray as $item) {
        //         $path = public_path() . '/' . $item . '/';
        //         if (!File::isDirectory($path)) {
        //             File::makeDirectory($path, 0777, true, true);
        //         }
        //     }

        //     foreach ($request->file('filenames') as $file) {
        //         $name = $file->getClientOriginalName();
        //         $path = public_path() . '/' . $pathToMove;
        //         $file->move($path, $name);
        //         $fileModel = new fileLoad();
        //         $fileModel->loadType()->associate(
        //             $load
        //         );
        //         $fileModel->filename = $name;
        //         $fileModel->save();

        //     }
        //     array_pop($filesArray);
        // }
        // $subject = LogsEnumConst::Update . LogsEnumConst::Load . $ref;
        // $logs = new LogActivity();
        // $logs->addToLog($subject, $request);
        // return response(['data' => $load], 201);

    }

    public function show($id)
    {

        $load = $this->loadService->show($id);
        if($load instanceof  Load){
            $response = LoadResponse::make($load);
            return  response()->json(['load'=>$response],Response::HTTP_OK);
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
            return response($validator->errors(), 400);
        }

        $load=$this->loadService->show($id);
        $file=$this->fileLoadService->getLoadId($id);
        if($load instanceof  Load){
            if ( $file instanceof  fileLoad){
                if($request->hasFile("filenames")){
                    $direction=$file->filename;
                    $folder="Loads";
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
                return  response()->json(['load'=>$response],Response::HTTP_OK);
            }
        }



//        $validator = Validator::make($request->all(), [
//            'amount' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
//            'load_related_to' => 'exists:users,id',
//            'load_types_name' => 'exists:load_types,name',
//            'TVA' => 'in:20,14,10',
//            'DATE_LOAD' => 'date_format:Y/m/d',
//            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
//            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
//        ]);
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//
//        $load = Load::findOrFail($id);
//
//        $amount = $request->input('amount');
//
//        $load_related_to = $request->input('load_related_to');
//        $load_types_name = $request->input('load_types_name');
//        $tva = $request->input('TVA');
//        $date = $request->input('DATE_LOAD');
//        $load->update([
//            "amount" => $amount,
//            "load_related_to" => $load_related_to,
//            "load_types_name" => $load_types_name,
//            "TVA" => $tva,
//            "DATE_LOAD" => $date,
//        ]);
//        if ($request->hasfile('filenames')) {
//
//            $filesArray = [
//                'geoMapping',
//                'geoMapping/Load',
//            ];
//            $pathToMove = 'geoMapping/Load/' . $load->REF;
//            array_push($filesArray, $pathToMove);
//            foreach ($filesArray as $item) {
//                $path = public_path() . '/' . $item . '/';
//                if (!File::isDirectory($path)) {
//                    File::makeDirectory($path, 0777, true, true);
//                }
//            }
//            foreach ($request->file('filenames') as $file) {
//                $name = $file->getClientOriginalName();
//                $path = public_path() . '/' . $pathToMove;
//                $file->move($path, $name);
//                $fileModel = new fileLoad();
//                $fileModel->loadType()->associate(
//                    $load
//                );
//                $fileModel->filename = $name;
//                $fileModel->save();
//
//            }
//            array_pop($filesArray);
//        }
//        return response(['data' => $load], 200);
    }

    public function destroy($id)
    {
        $load= $this->loadService->show($id);
        $file= $this->fileLoadService->getLoadId($id);
        if($load instanceof Load){
             $this->loadService->destroy($id);
             if($file instanceof  fileLoad){
                 $this->saveFileService->deleteFile($file->filename);
                 return response(['data' => null], Response::HTTP_OK);
             }
        }
        return response(['error' => "bad Reaquest"], Response::HTTP_BAD_REQUEST);
    }
}
