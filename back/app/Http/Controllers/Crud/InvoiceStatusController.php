<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\InvoiceStatusRequest;
use App\Models\InvoiceStatus;
use App\Response\InvoiceStatus\InvoicesStatusResponse;
use App\Response\InvoiceStatus\InvoiceStatusResponse;
use App\Services\InvoiceStatus\IInvoiceStatusService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class InvoiceStatusController extends Controller
{
    private $iInvoiceStatusService;
    public function __construct(IInvoiceStatusService $iInvoiceStatusService)
    {
         set_time_limit(8000000);
         $this->middleware('role:EtatFacture_create|owner|admin', ['only' => ['store']]);
         $this->middleware('role:EtatFacture_edit|owner|admin', ['only' => ['update']]);
         $this->middleware('role:EtatFacture_read|owner|admin', ['only' => ['index']]);
         $this->middleware('role:EtatFacture_delete|owner|admin', ['only' => ['destroy']]);
        $this->iInvoiceStatusService=$iInvoiceStatusService;
    }


    public function index(PaginationRequest $request)
    {
        $res = $this->iInvoiceStatusService->index($request);
        if($res instanceof LengthAwarePaginator){
            $response = InvoicesStatusResponse::make($res->all());
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
    public function store(InvoiceStatusRequest $request)
    {
        $invoicestatus = $this->iInvoiceStatusService->save($request);
        if($invoicestatus instanceof InvoiceStatus){
            $response= InvoiceStatusResponse::make($invoicestatus);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $invoicestatus = $this->iInvoiceStatusService->show($id);
        if($invoicestatus instanceof InvoiceStatus){
            $response= InvoiceStatusResponse::make($invoicestatus);
            return response()->json([
                "data"=>$response
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(InvoiceStatusRequest $request, $id)
    {
        $invoicestatus = $this->iInvoiceStatusService->update($id,$request);
        if($invoicestatus instanceof InvoiceStatus){
            $response= InvoiceStatusResponse::make($invoicestatus);
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
            $res=$this->iInvoiceStatusService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
