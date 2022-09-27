<?php
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FeesFolderTechRequest;
use App\Models\FeesFolderTech;
use App\Response\FeesFolderTech\FeesFolderTechResponse;
use App\Response\FeesFolderTech\FeesFolderTechsResponse;
use App\Services\FeesFolderTech\IFeesFolderTechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class FeesFolderTechController extends Controller
{
    private $iFeesFolderTechService;
    public function __construct(IFeesFolderTechService $iFeesFolderTechService)
    {
        $this->iFeesFolderTechService=$iFeesFolderTechService;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $feesfolderteches = $this->iFeesFolderTechService->index($request->all());

       if($feesfolderteches instanceof LengthAwarePaginator){
            $response=FeesFolderTechsResponse::make($feesfolderteches);
            return response()->json([
                'feesfolderteche'=>$response->items(),
                'total'=>$feesfolderteches->total(),
                'lastPage'=>$feesfolderteches->lastPage(),
                'currentPage'=>$feesfolderteches->currentPage(),
            ],Response::HTTP_OK);
        }else{

        }
    }

    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required|exists:folderteches,id',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $feesfoldertech = $this->iFeesFolderTechService->save($request);

        if($feesfoldertech instanceof FeesFolderTech){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'feesfolderteche'=>$response
            ],Response::HTTP_CREATED);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }

    }

    public function show($id)
    {
        $feesfoldertech = $this->iFeesFolderTechService->show($id);
        if($feesfoldertech instanceof FeesFolderTech){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'feesfolderteche'=>$response
            ],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(FeesFolderTechRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required|exists:folderteches,id',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $feesfoldertech = $this->iFeesFolderTechService->update($request,$id);

       if($feesfoldertech instanceof FeesFolderTech){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'feesfolderteche'=>$response
            ],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $feesfoldertech = $this->iFeesFolderTechService->destroy($id);

        if($feesfoldertech instanceof FeesFolderTech){
             $response=FeesFolderTechResponse::make($feesfoldertech);
             return response()->json([
                 'feesfolderteche'=>$response
             ],Response::HTTP_OK);
         }else{
             return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
         }
    }
}
