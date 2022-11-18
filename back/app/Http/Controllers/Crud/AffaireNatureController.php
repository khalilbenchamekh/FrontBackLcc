<?php
namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\AffaireNatureArrayRequest;
use App\Http\Requests\Crud\AffaireNatureRequest;
use App\Http\Requests\Enums\OperationChoice;
use App\Models\AffaireNature;
use App\Response\AffaireNature\AffaireNatureResponse;
use App\Response\AffaireNature\AllAffaireNatureResponse;
use App\Services\AffaireNature\IAffaireNatureService;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AffaireNatureController extends Controller
{
    private $affaireNatureService;
    public function __construct(IAffaireNatureService $affaireNatureService)
    {
        $this->affaireNatureService=$affaireNatureService;
        $this->middleware('role:affairenatures_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:affairenatures_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:affairenatures_read|owner|admin', ['only' => ['index']]);
       $this->middleware('role:affairenatures_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(PaginationRequest $request)
    {
        $affairenatures=$this->affaireNatureService->getAllAffaireNature($request);
        if($affairenatures instanceof  LengthAwarePaginator ){
            $response= AllAffaireNatureResponse::make($affairenatures->items());
            return response()->json([
                'data'=>$response,
                'total'=>$affairenatures->total(),
                'lastPage'=>$affairenatures->lastPage(),
                'currentPage'=>$affairenatures->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(AffaireNatureRequest $request)
    {
        $affaireNature=$this->affaireNatureService->store($request->all());
        if($affaireNature === true){
            return response()->json(['error'=>"Name exist"],Response::HTTP_BAD_REQUEST);
        }
        if($affaireNature instanceof AffaireNature){
            $response=AffaireNatureResponse::make($affaireNature);
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            return response()->json(["error"=>"Affaire Nature No Create"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getAffaireNature($id)
    {
        $affaireNature=$this->affaireNatureService->get($id);
        if ($affaireNature instanceof AffaireNature){
            $response= AffaireNatureResponse::make($affaireNature);
            return response()->json(['data'=>$response],Response::HTTP_OK);
        }
                  return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
    }

    public function edit($id,AffaireNatureRequest $request)
    {
        $affaireNature=$this->affaireNatureService->edit($id,$request->all());
        if($affaireNature===true){
            return response()->json(['errors'=>"Name exist"],Response::HTTP_BAD_REQUEST);
        }
        if ($affaireNature instanceof AffaireNature){
            $response= AffaireNatureResponse::make($affaireNature);
            return response()->json(['data'=>$response],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
    }

    public function storeMany(AffaireNatureArrayRequest $request)
    {
        $saveManyAffaires= $this->affaireNatureService->saveMany($request->all());
        return response()->json(["data"=>$saveManyAffaires],Response::HTTP_CREATED);
    }

    private function treatment(Request $request, String $choice, $extera)
    {
        if ($choice == OperationChoice::SAVE) {
            $response = $this->affaireNatureService->store($request);
            $affairenature= AffaireNatureResponse::make($response);
        }
        if ($choice == OperationChoice::UPDATE) {
            $response = $this->affaireNatureService->edit($extera,$request);
            $affairenature= AffaireNatureResponse::make($response);
        }
        if ($choice == OperationChoice::MULTIPLE) {
            $affaires = $request->all();
            $response = $this->affaireNatureService->saveMany($affaires);
            $affairenature= AllAffaireNatureResponse::make($response->items());
        }

        return response(['data' => $affairenature], $choice === OperationChoice::SAVE ? 201 : 200);
    }

    public function show($id)
    {
        $res=$this->affaireNatureService->get($id);
        if(!is_null($res) ){
             $response= AffaireNatureResponse::make($res);
             return response()->json(['data'=>$response],Response::HTTP_OK);
         }
         return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
    }

    public function update(AffaireNatureRequest $request, $id)
    {
        $operation = OperationChoice::UPDATE;
        return $this->treatment($request, $operation, $id);
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
        $res=$this->affaireNatureService->destroy($request);
        if(!is_null($res) ){
             return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
}
