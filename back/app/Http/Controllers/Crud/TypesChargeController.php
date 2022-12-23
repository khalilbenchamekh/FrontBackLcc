<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\TypesChargeRequest;
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
    {
        set_time_limit(8000000);
        $this->middleware('role:typeCharge_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:typeCharge_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:typeCharge_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:typeCharge_delete|owner|admin', ['only' => ['destroy']]);
        $this->iTypesChargeService = $iTypesChargeService;
    }
    public function index(PaginationRequest $request)
    {
        $res = $this->iTypesChargeService->index($request);
        if ($res instanceof LengthAwarePaginator) {
            $response = TypesChargesResponse::make($res);
            return response()->json([
                "data" => $response,
                'countPage' => $response->perPage(),
                "currentPage" => $response->currentPage(),
                "nextPage" => $response->currentPage() < $response->lastPage() ? $response->currentPage() + 1 : $response->currentPage(),
                "lastPage" => $response->lastPage(),
                'total' => $response->total(),
            ], Response::HTTP_OK);
        }
        return response()->json(["error" => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function store(TypesChargeRequest $request)
    {
        $typescharge = $this->iTypesChargeService->save($request);
        if ($typescharge instanceof TypesCharge) {
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "data" => $response,
            ], Response::HTTP_CREATED);
        }
        return response()->json(["error" => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $typescharge = $this->iTypesChargeService->show($id);
        if ($typescharge instanceof TypesCharge) {
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "data" => $response,
            ], Response::HTTP_OK);
        }
        return response()->json(["error" => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function update(TypesChargeRequest $request, $id)
    {

        $typescharge = $this->iTypesChargeService->update($id, $request);
        if ($typescharge instanceof TypesCharge) {
            $response = TypesChargeResponse::make($typescharge);
            return response()->json([
                "data" => $response,
            ], Response::HTTP_OK);
        }
        return response()->json(["error" => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "integer"],
            "name" => ["required", "string"]
        ]);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        $res = $this->iTypesChargeService->destroy($request);
        if (!is_null($res)) {
            $response = TypesChargeResponse::make($res);
            return response()->json([
                "data" => $response,
            ], Response::HTTP_OK);
        } else {
            return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
        }
    }
}
