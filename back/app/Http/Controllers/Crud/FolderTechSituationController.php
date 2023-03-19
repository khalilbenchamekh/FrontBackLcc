<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\FolderTechSituationRequest;
use App\Models\FolderTechSituation;
use App\Response\FolderTechSituation\FolderTechSituationResponse;
use App\Response\FolderTechSituation\FolderTechSituationsResponse;
use App\Services\FolderTechSituation\IFolderTechSituationService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FolderTechSituationController extends Controller
{
    private $iFolderTechSituationService;
    public function __construct(IFolderTechSituationService $iFolderTechSituationService)
    {
         set_time_limit(8000000);
         $this->middleware('role:owner|admin');
         $this->middleware('role:foldertechsituations_create|owner|admin', ['only' => ['storeMany']]);
         $this->middleware('role:foldertechsituations_edit|owner|admin', ['only' => ['update']]);
         $this->middleware('role:foldertechsituations_read|owner|admin', ['only' => ['index']]);
         $this->middleware('role:foldertechsituations_delete|owner|admin', ['only' => ['destroy']]);
        $this->iFolderTechSituationService=$iFolderTechSituationService;
    }
    public function index(PaginationRequest $request)
    {
        $foldertechsituations = $this->iFolderTechSituationService->index($request);
        if($foldertechsituations instanceof LengthAwarePaginator){
            $response = FolderTechSituationsResponse::make($foldertechsituations->items());
            return response()->json([
                "data"=>$response,
                'countPage'=>$foldertechsituations->perPage(),
                "currentPage"=>$foldertechsituations->currentPage(),
                "nextPage"=>$foldertechsituations->currentPage()<$foldertechsituations->lastPage()?$foldertechsituations->currentPage()+1:$foldertechsituations->currentPage(),
                "lastPage"=>$foldertechsituations->lastPage(),
                'total'=>$foldertechsituations->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function store(FolderTechSituationRequest $request)
    {
        $foldertechsituation = $this->iFolderTechSituationService->save($request);
        if($foldertechsituation instanceof FolderTechSituation){
            $response = FolderTechSituationResponse::make($foldertechsituation);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_CREATED);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function storeMany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foldertechsituation.*.Name' => 'required|string|min:4|max:255|distinct|unique:App\Models\FolderTechSituation',
            'foldertechsituation.*.orderChr' => 'integer|between:0,10',
        ]);

        if($validator->fails()) {
            return response($validator->errors(),400);
        }
        $foldertechsituations=$this->iFolderTechSituationService->storeMany($request);
        if(is_array($foldertechsituations) && !empty($foldertechsituations)){
            $response = FolderTechSituationsResponse::make($foldertechsituations);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $foldertechsituation = $this->iFolderTechSituationService->show($id);
        if($foldertechsituation instanceof FolderTechSituation){
            $response = FolderTechSituationResponse::make($foldertechsituation);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_OK);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(FolderTechSituationRequest $request, $id)
    {
        $foldertechsituation = $this->iFolderTechSituationService->update($id,$request);
        if($foldertechsituation instanceof FolderTechSituation){
            $response = FolderTechSituationResponse::make($foldertechsituation);
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
            "Name"=>["required","string"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->iFolderTechSituationService->destroy($request);
            if(!is_null($res) ){
                $response = FolderTechSituationResponse::make($res);
                return response()->json(['data' => $response], Response::HTTP_OK);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
