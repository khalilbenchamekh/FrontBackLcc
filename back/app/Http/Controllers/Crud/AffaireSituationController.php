<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\AffaireSituationArrayRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\AffaireSituationRequest;
use App\Models\AffaireSituation;
use App\Response\AffaireSituation\AffaireSituationResponse;
use App\Response\AffaireSituation\AffaireSituationsResponse;
use App\Services\AffaireSituation\IAffaireSituationService;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class AffaireSituationController extends Controller
{
    private $affaireSituationService;
    public function __construct(IAffaireSituationService $affaireSituationService)
    {
        $this->affaireSituationService=$affaireSituationService;
      $this->middleware('role:affairesituations_create|owner|admin', ['only' => ['store', 'storeMany']]);
      $this->middleware('role:affairesituations_edit|owner|admin', ['only' => ['update']]);
       $this->middleware('role:affairesituations_read|owner|admin', ['only' => ['index']]);
       $this->middleware('role:affairesituations_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(PaginationRequest $request)
    {
        $affaireSatuations=$this->affaireSituationService->index($request);
        if($affaireSatuations instanceof LengthAwarePaginator ){
            $response=AffaireSituationsResponse::make($affaireSatuations);
            return response()->json([
                'data'=>$response->items(),
                "total"=>$affaireSatuations->total(),
                "currentPage"=>$affaireSatuations->currentPage(),
                "lastPage"=>$affaireSatuations->lastPage()
            ],Response::HTTP_OK);
        }
        return \response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);
    }

    public function storeMany(AffaireSituationArrayRequest $request)
    {
        $check=  $this->affaireSituationService->validName($request->all()['affaireSituations']);
        if(count($check)>0){
            return  response()->json(["error"=>$check],Response::HTTP_CREATED);
        }
        $affaireSituations=$this->affaireSituationService->storeMany($request);
        if(is_array($affaireSituations) && count($affaireSituations)>0){
            return  response()->json(["data"=>$affaireSituations],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);
    }

    public function store(AffaireSituationRequest $request)
    {
        $affairesituation=$this->affaireSituationService->store($request);
        if($affairesituation instanceof AffaireSituation){
           $response=AffaireSituationResponse::make($affairesituation);
           return response()->json(["data"=>$response],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $affairesituation=$this->affaireSituationService->get($id);
        if($affairesituation instanceof AffaireSituation){
            $response=AffaireSituationResponse::make($affairesituation);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(AffaireSituationRequest $request, $id)
    {
        $perAffaireSituation=$this->affaireSituationService->get($id);
        if($perAffaireSituation instanceof  AffaireSituation){
            $affairesituation=$this->affaireSituationService->edit($perAffaireSituation,$request);
            if($affairesituation instanceof AffaireSituation){
                $response=AffaireSituationResponse::make($affairesituation);
                return response()->json(["data"=>$response],Response::HTTP_OK);
            }
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "Name"=>["required","string"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $res=$this->affaireSituationService->delete($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
