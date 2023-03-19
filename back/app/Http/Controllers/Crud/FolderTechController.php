<?php
namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\FolderTechRequest;
use App\Models\FolderTech;
use App\Response\FolderTech\FolderTechResponse;
use App\Response\FolderTech\FolderTechsResponse;
use App\Services\AffaireSituation\IAffaireSituationService;
use App\Services\Client\IClientService;
use App\Services\FolderTech\IFolderTechService;
use App\Services\SaveFile\ISaveFileService;
use App\Services\User\IUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class FolderTechController extends Controller
{
    private $iClientService;
    private  $iFolderTechService;
    private $affaireSituationService;
    private $iUserService;
    private $saveFileService;

    public function __construct(IFolderTechService $iFolderTechService,
    IClientService $iClientService,
    IUserService $iUserService,
    IAffaireSituationService $affaireSituationService,
    ISaveFileService $saveFileService)
    {
        set_time_limit(8000000);
        $this->middleware('role:foldertechnatures_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:foldertechnatures_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:foldertechnatures_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:foldertechnatures_delete|owner|admin', ['only' => ['destroy']]);
        $this->iFolderTechService = $iFolderTechService;
        $this->affaireSituationService=$affaireSituationService;
        $this->iClientService=$iClientService;
        $this->affaireSituationService=$affaireSituationService;
        $this->iUserService=$iUserService;
        $this->saveFileService=$saveFileService;
    }

    public function index(PaginationRequest $request)
    {
        $res = $this->iFolderTechService->index($request);
       if($res instanceof LengthAwarePaginator ){
            $response=FolderTechsResponse::make($res->items());
            return response()->json([
                "data"=>$response,
                'countPage'=>$res->perPage(),
                "currentPage"=>$res->currentPage(),
                "nextPage"=>$res->currentPage()<$res->lastPage()?$res->currentPage()+1:$res->currentPage(),
                "lastPage"=>$res->lastPage(),
                'total'=>$res->total(),
            ],Response::HTTP_OK);
        }
         return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function store(FolderTechRequest $request)
    {
        $res=$this->iFolderTechService->save($request);
        if ($res instanceof FolderTech){
            if ($request->hasfile('filenames')) {
                $path = 'Dossier Technique/Dossier Technique' . $res->REF;
                $this->saveFileService->saveFeesFiles($res,$path,$request->file('filenames'));
            }
            $response=FolderTechResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $res= $this->iFolderTechService->show($id);
        if (!is_null($res)) {
            $response = FolderTechResponse::make($res);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function update(FolderTechRequest $request, $id)
    {
        $res= $this->iFolderTechService->update($id,$request);
        if (!is_null($res)) {
            $response = FolderTechResponse::make($res);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "REF"=>["required","string"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $res=$this->iFolderTechService->delete($request);
            if(!is_null($res) ){
                $response = FolderTechResponse::make($res);
                return response()->json(['data' => $response], Response::HTTP_OK);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
