<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
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
        // set_time_limit(8000000);
        // $this->middleware('role:intermediates_create|owner|admin', ['only' => ['store']]);
        // $this->middleware('role:intermediates_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:intermediates_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:intermediates_delete|owner|admin', ['only' => ['destroy']]);
        $this->iIntermediateService=$iIntermediateService;
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
        $intermediates = $this->iIntermediateService->index($request);
        if($intermediates instanceof LengthAwarePaginator){
            $response=IntermediatesResponse::make($intermediates->all());
            return response()->json([
                "intermediates"=>$response,
                'total'=>$intermediates->total(),
                'lastPage'=>$intermediates->lastPage(),
                'currentPage'=>$intermediates->currentPage(),
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
                "intermediate"=>$response
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
                "intermediate"=>$response
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
                "intermediate"=>$response
            ],Response::HTTP_OK);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        $intermediate = $this->iIntermediateService->destroy($id);
        if($intermediate instanceof Intermediate){
            $response=IntermediateResponse::make($intermediate);
            return response()->json([
                "intermediate"=>$response
            ],Response::HTTP_OK);
        }

        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
