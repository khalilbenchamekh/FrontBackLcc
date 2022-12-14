<?php
namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
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

    public function index(PaginationRequest $request)
    {
        $feesfolderteches = $this->iFeesFolderTechService->index($request->all());
       if($feesfolderteches instanceof LengthAwarePaginator){
            $response=FeesFolderTechsResponse::make($feesfolderteches);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
         return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
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
        if(!is_null($feesfoldertech) ){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'data'=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $feesfoldertech = $this->iFeesFolderTechService->show($id);
        if(!is_null($feesfoldertech) ){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'data'=>$response
            ],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
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
        if(!is_null($feesfoldertech) ){
            $response=FeesFolderTechResponse::make($feesfoldertech);
            return response()->json([
                'data'=>$response
            ],Response::HTTP_OK);
        }
         return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->iFeesFolderTechService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
