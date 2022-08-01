<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\LoadTypesRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\LoadTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\LoadTypes\ILoadTypesService;
use Symfony\Component\HttpFoundation\Response;
use App\Response\LoadTypes\LoadTypesResponse;
use function Spatie\DataTransferObject\toArray;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Response\LoadTypes\LoadTypeResponse;


class LoadTypesController extends Controller
{

    private $loadtypes;
    public function __construct(ILoadTypesService $loadtypes )
    {
        $this->loadtypes=$loadtypes;
        // set_time_limit(8000000);
        // $this->middleware('role:loadtypes_create|owner|admin', ['only' => ['storeMany', 'storeMany']]);
        // $this->middleware('role:loadtypes_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:loadtypes_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:loadtypes_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "page"=>["required","integer"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        $idUser=3;
        $type= $this->loadtypes->index($idUser,$request->input("page"));

       if($type instanceof LengthAwarePaginator){
        $response =  LoadTypesResponse::make($type);
        return response()->json($response,Response::HTTP_OK);
       }
        if(!$type instanceof LoadType){
                return response()->json(["error"=>"bad request"], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(LoadTypesRequest $request)
    {
       //dd(gettype($request->all()) );

        $loadType=$this->loadtypes->store($request->all());
        if(!$loadType instanceof LoadTypes){
            return response()->json(["error"=>"Bed Request"],Response::HTTP_BAD_REQUEST);
        }





       // $loadtypes = new LoadTypes();
       // $loadtypes->name = $request->input("name");
        //$loadtypes->save();
        //return response(['data' => $loadtypes], 201);

    }

    public function storeMany(Request $request)
    {

        $validator= Validator::make($request->all(),[
            'loadtype.*.name' => 'required|string|min:4|max:255|distinct|unique:App\Models\LoadTypes',
            'loadtype.*.organisation_id'=>'required|integer'
        ]);

            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }

            $loadtypes=$this->loadtypes->saveManyLoadTypes($request->all());
            if(is_array($loadtypes) && count($loadtypes)>0){

                return response()->json(["message"=>"loadtypes created"],Response::HTTP_CREATED);
            }

            return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);

       // $validator = Validator::make($request->all(), [
         //   '*.name' => 'required|string|min:4|max:255|distinct|unique:App\Models\LoadTypes',
       // ]);

        // if ($validator->fails()) {
        //     return response($validator->errors(), 400);
        // }
        // $load_types = $request->all();
        // $load_type_records = [];
        // foreach ($load_types as $loadtype) {
        //     if (!empty($loadtype)) {
        //         $load_type_records[] = [
        //             'name' => $loadtype['name'],
        //         ];
        //         $subject = LogsEnumConst::Add . LogsEnumConst::LoadType . $loadtype['name'];
        //    $logs = new LogActivity();
        // $logs->addToLog($subject, $request);
        //     }
        // }

        // $loadtypes = LoadTypes::insert($load_type_records);
        // return response(['data' => $loadtypes], 201);

    }

    public function show($id)
    {

        $loadType =$this->loadtypes->get($id);

        if(!$loadType instanceof LoadTypes){
            return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }

        if($loadType instanceof LoadTypes){
            $response= LoadTypeResponse::make($loadType);
            return response()->json(["loadtype"=>$response],Response::HTTP_OK);
        }

       // $loadtypes = LoadTypes::findOrFail($id);

        //return response(['data', $loadtypes], 200);
    }

    public function update(LoadTypesRequest $request, $id)
    {

        $perLoadType=$this->isLoaType($id);
        if($perLoadType instanceof LoadTypes){
            $data= $request->all();
            $loadType= $this->loadtypes->edit($data,$perLoadType);
            if(!$loadType instanceof LoadTypes){
                return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
            }
            if($loadType instanceof LoadTypes){
                $response= LoadTypeResponse::make($loadType);
                return response()->json(["loadtype"=>$response],Response::HTTP_OK);
            }
        }else{
            return response()->json(["error"=>"LoadType not exist"],Response::HTTP_NO_CONTENT);
        }




       // $loadtypes = LoadTypes::findOrFail($id);
        //$loadtypes->update($request->all());
        //$subject = LogsEnumConst::Update . LogsEnumConst::LoadType . $loadtypes['name'];
      //$logs = new LogActivity();
        //$logs->addToLog($subject, $request);
        //return response(['data' => $loadtypes], 200);
    }
    private function isLoaType($id)
    {
        $loadType=$this->loadtypes->get($id);
        if($loadType instanceof LoadTypes ){
            return $loadType;
        }
        return null;
    }

    public function destroy($id)
    {
        $perLoadType=$this->isLoaType($id);
        if($perLoadType === null){
            return response()->json(["error"=>"LoadType not exist"],Response::HTTP_BAD_REQUEST);
        }
        $destroy = $this->loadtypes->delete($id,$perLoadType);
        if($destroy instanceof LoadTypes){
            $response = LoadTypeResponse::make($destroy);
            return response()->json(["LoadType"=>$response],Response::HTTP_OK);
        }else{
            return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
}
