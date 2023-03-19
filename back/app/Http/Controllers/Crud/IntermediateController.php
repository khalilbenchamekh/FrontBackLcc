<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\IntermediateRequest;
use App\Models\Intermediate;
use App\Response\Intermediate\IntermediateResponse;
use App\Response\Intermediate\IntermediatesResponse;
use App\Services\Intermediate\IIntermediateService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class IntermediateController extends Controller
{
    private $iIntermediateService;
    public function __construct(IIntermediateService $iIntermediateService)
    {
        set_time_limit(8000000);
         $this->middleware('role:intermediates_create|owner|admin', ['only' => ['store']]);
         $this->middleware('role:intermediates_edit|owner|admin', ['only' => ['update']]);
         $this->middleware('role:intermediates_read|owner|admin', ['only' => ['index']]);
         $this->middleware('role:intermediates_delete|owner|admin', ['only' => ['destroy']]);
        $this->iIntermediateService=$iIntermediateService;
    }

    public function index(PaginationRequest $request)
    {
        $res = $this->iIntermediateService->index($request);
        if($res instanceof LengthAwarePaginator){
            $response = IntermediatesResponse::make($res->items());
            return response()->json([
                "data"=>$response,
                'countPage'=>$res->perPage(),
                "currentPage"=>$res->currentPage(),
                "nextPage"=>$res->currentPage()<$res->lastPage()?$res->currentPage()+1:$res->currentPage(),
                "lastPage"=>$res->lastPage(),
                'total'=>$res->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function store(IntermediateRequest $request)
    {
        $intermediate = $this->iIntermediateService->save($request);
        if($intermediate instanceof Intermediate){
            $response=IntermediateResponse::make($intermediate);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $intermediate = $this->iIntermediateService->show($id);
        if($intermediate instanceof Intermediate){
            $response=IntermediateResponse::make($intermediate);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_OK);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(IntermediateRequest $request, $id)
    {
        $intermediate = $this->iIntermediateService->update($id,$request);
        if($intermediate instanceof Intermediate){
            $response=IntermediateResponse::make($intermediate);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_OK);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
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
            $res=$this->iIntermediateService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_OK);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
