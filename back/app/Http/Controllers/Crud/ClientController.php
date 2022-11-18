<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\ClientParticularRequest;
use App\Http\Requests\Crud\ClientRequest;
use App\Http\Requests\Crud\ClientUpdateRequest;
use App\Models\Client;
use App\Response\Client\ClientParticularResponse;
use App\Response\Client\ClientsResponse;
use App\Response\Client\ClientResponse;
use App\Services\Client\IClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientController extends Controller
{
    private $iClientService;
    public function __construct(IClientService $iClientService)
    {
        set_time_limit(8000000);
        $this->middleware('role:clients_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:clients_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:clients_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:clients_delete|owner|admin', ['only' => ['destroy']]);
        $this->iClientService=$iClientService;
    }
    public function index(PaginationRequest $request)
    {
        $res=$this->iClientService->index($request);
        if($res instanceof LengthAwarePaginator){
            $response =  ClientsResponse::make($res->items());
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

    public function storeBusiness(ClientRequest $request)
    {
        $bus = $this->iClientService->business($request->all());
        if(!is_null($bus) ){
            $res=$this->iClientService->storeBusiness($request->all(),$bus);
            if(!is_null($res) ){
                $response=ClientResponse::make($res);
                return response()->json($response,Response::HTTP_CREATED);
            }
        }
        return response()->json(["error"=>"storeBusiness Not Created"],Response::HTTP_BAD_REQUEST);
    }

    public function storeParticular(ClientParticularRequest $request)
    {
        $bus = $this->iClientService->newParticular($request->all());
        if(!is_null($bus) ){
            $res=$this->iClientService->storeBusiness($request->all(),$bus);
            if(!is_null($res) ){
                $response=ClientParticularResponse::make($res);
                return response()->json($response,Response::HTTP_CREATED);
            }
        }
        return response()->json(["error"=>"storeBusiness Not Created"],Response::HTTP_BAD_REQUEST);
    }

    public function store(ClientRequest $request)
    {
        $client=$this->iClientService->store($request->all());
         if(!is_null($client ) ){
            $response=ClientResponse::make($client);
            return response()->json($response,Response::HTTP_CREATED);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }
    public function show($id)
    {
        $client= $this->iClientService->get($id);
            if(!is_null($client ) ){
            $response = ClientResponse::make($client);
            return response()->json(["client"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        $client= $this->iClientService->editBusiness($request->all(),$id);
            if(!is_null($client ) ){
            $response = ClientResponse::make($client);
            return response()->json(["client"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "ICE"=>["required","string"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $res=$this->iClientService->delete($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
