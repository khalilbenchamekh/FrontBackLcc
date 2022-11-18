<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\LoadTypesRequest;
use App\Models\LoadTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\LoadTypes\ILoadTypesService;
use Symfony\Component\HttpFoundation\Response;
use App\Response\LoadTypes\LoadTypesResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Response\LoadTypes\LoadTypeResponse;

class LoadTypesController extends Controller
{

    private $loadtypes;
    public function __construct(ILoadTypesService $loadtypes )
    {
        $this->loadtypes=$loadtypes;
        set_time_limit(8000000);
         $this->middleware('role:loadtypes_create|owner|admin', ['only' => ['storeMany', 'storeMany']]);
         $this->middleware('role:loadtypes_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:loadtypes_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:loadtypes_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(PaginationRequest $request)
    {
        $res= $this->loadtypes->index($request);
       if($res instanceof LengthAwarePaginator){
        $response =  LoadTypesResponse::make($res);
        return response()->json($response,Response::HTTP_OK);
       }
       return response()->json(["error"=>"Bed Request"],Response::HTTP_BAD_REQUEST);
    }

    public function store(LoadTypesRequest $request)
    {
        $affairesituation=$this->loadtypes->store($request->all());
        if($affairesituation instanceof LoadTypes){
           $response=LoadTypeResponse::make($affairesituation);
           return response()->json(["data"=>$response],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
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
    }

    public function show($id)
    {
        $affairesituation=$this->loadtypes->get($id);
        if($affairesituation instanceof LoadTypes){
            $response=LoadTypeResponse::make($affairesituation);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(LoadTypesRequest $request, $id)
    {
        $perLoadType=$this->isLoaType($id);
        if(!is_null($perLoadType)){
            $data= $request->all();
            $loadType= $this->loadtypes->edit($data,$perLoadType);
            if(!is_null($loadType)){
                $response= LoadTypeResponse::make($loadType);
                return response()->json(["data"=>$response],Response::HTTP_OK);
            }
        }
        return response()->json(["error"=>"LoadType not exist"],Response::HTTP_NO_CONTENT);
    }
    private function isLoaType($id)
    {
        return $this->loadtypes->get($id);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "name"=>["required","string"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
        $res = $this->loadtypes->delete($request);
        if(!is_null($res) ){
            return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
        }else{
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
       }
    }
}
