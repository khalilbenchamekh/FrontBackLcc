<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
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
        // set_time_limit(8000000);
        // $this->middleware('role:EtatFacture_create|owner|admin', ['only' => ['store']]);
        // $this->middleware('role:EtatFacture_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:EtatFacture_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:EtatFacture_delete|owner|admin', ['only' => ['destroy']]);
        $this->iInvoiceStatusService=$iInvoiceStatusService;

    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $invoicestatuses = $this->iInvoiceStatusService->index($request);
        if($invoicestatuses instanceof LengthAwarePaginator){
            $response= InvoicesStatusResponse::make($invoicestatuses->all());
            return response()->json([
                "invoicesStatuses"=>$response,
                'total'=>$invoicestatuses->total(),
                'lastPage'=>$invoicestatuses->lastPage(),
                'currentPage'=>$invoicestatuses->currentPage(),
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
                "invoiceStatuses"=>$response
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
                "invoiceStatuses"=>$response
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
                "invoiceStatuses"=>$response
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        $invoicestatus =  $this->iInvoiceStatusService->destroy($id);
        if($invoicestatus instanceof InvoiceStatus){
            $response=InvoiceStatusResponse::make($invoicestatus);
            return response()->json([
                "invoicetatuses"=>$response
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
