<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\TypesChargeRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\TypesCharge;
use App\Response\TypesCharge\TypesChargeResponse;
use App\Response\TypesCharge\TypesChargesResponse;
use App\Services\TypesCharge\ITypesChargeService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TypesChargeController extends Controller
{
    private $iTypesChargeService;
    public function __construct(ITypesChargeService $iTypesChargeService)
    {;
        // set_time_limit(8000000);
        // $this->middleware('role:typeCharge_create|owner|admin', ['only' => ['store']]);
        // $this->middleware('role:typeCharge_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:typeCharge_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:typeCharge_delete|owner|admin', ['only' => ['destroy']]);
        $this->iTypesChargeService=$iTypesChargeService;
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
        $typescharges = $this->iTypesChargeService->index($request);
        if($typescharges instanceof LengthAwarePaginator){
            $response=TypesChargesResponse::make($typescharges->all());
            return response()->json([
                "typescharges"=>$response,
                'total'=>$typescharges->total(),
                'lastPage'=>$typescharges->lastPage(),
                'currentPage'=>$typescharges->currentPage(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function store(TypesChargeRequest $request)
    {
        $typescharge = $this->iTypesChargeService->save($request);
        if($typescharge instanceof TypesCharge){
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "typescharge"=>$response,
            ],Response::HTTP_CREATED);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $typescharge = $this->iTypesChargeService->show($id);
        if($typescharge instanceof TypesCharge){
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "typescharge"=>$response,
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(TypesChargeRequest $request, $id)
    {
        $typescharge = $this->iTypesChargeService->update($id,$request);
        if($typescharge instanceof TypesCharge){
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "typescharge"=>$response,
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        $typescharge =  $this->iTypesChargeService->destroy($id);
        if($typescharge instanceof TypesCharge){
            $response=TypesChargeResponse::make($typescharge);
            return response()->json([
                "invoicetatuses"=>$response
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
