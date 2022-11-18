<?php
namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\Crud\FolderTechRequest;
use App\Models\FolderTech;
use App\Response\FolderTechNature\FolderTechResponse;
use App\Response\FolderTechNature\FolderTechsResponse;
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
        $res = $this->iFolderTechService->index($request->all());
       if($res instanceof LengthAwarePaginator){
            $response=FolderTechsResponse::make($res);
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

    public function store(FolderTechRequest $request)
    {
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        if (!empty($longitude) || !empty($latitude)) {
            $validator = Validator::make($request->all(), [
                'longitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'latitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        }
        $ttc = $request->input('ttc');
        if (!empty($ttc)) {
            $validator = Validator::make($request->all(), [
                'ttc' => 'in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        }

        $client = $this->iClientService->get($request->input('client_id'));
        if(is_null($client)){
            return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
        }

        $affaireSituation = $this->affaireSituationService->get($request->input('aff_sit_id'));
        if(is_null($affaireSituation)){
            return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
        }

        $responsible = $this->iUserService->get($request->input('resp_id'));
        if(is_null($responsible)){
            return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
        }

        $res=$this->iFolderTechService->save($request->all());
        if ($res instanceof FolderTech){
            $path = 'Dossier Technique/Dossier Technique' . $res->REF;
            $this->saveFileService->saveFeesFiles($res,$path,$request->file('filenames'));
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
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
