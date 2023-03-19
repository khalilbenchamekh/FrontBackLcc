<?php


namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\AffaireRequest;
use App\Response\Affaire\AffaireResponse;
use App\Response\Affaire\AffairesResponse;
use App\Services\Affaire\IAffaireService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
class AffaireController extends Controller
{
    private $affaireService;
    private $saveFileService;
    public function __construct(IAffaireService $affaireService,ISaveFileService $saveFileService)
    {
        $this->affaireService = $affaireService;
        $this->saveFileService = $saveFileService;
    //    $this->middleware('role:owner');
    //     $this->middleware('role:affaires_create|owner|admin', ['only' => ['store']]);
    //     $this->middleware('role:affaires_edit|owner|admin', ['only' => ['update']]);
    //     $this->middleware('role:affaires_read|owner|admin', ['only' => ['index']]);
    //     $this->middleware('role:affaires_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(PaginationRequest $request)
    {
        $res=$this->affaireService->index($request->all());
        if($res instanceof  LengthAwarePaginator ){
            $response= AffairesResponse::make($res->items());
            return response()->json([
                'data'=>$response,
                'total'=>$res->total(),
                'lastPage'=>$res->lastPage(),
                'currentPage'=>$res->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(AffaireRequest $request)
    {
        // $ttc = $request->input('ttc');
        // if (!empty($ttc)) {
        //     $validator = Validator::make($request->all(), [
        //         'ttc' => 'in:0,1',
        //     ]);
        //     if ($validator->fails()) {
        //         return response($validator->errors(),Response::HTTP_BAD_REQUEST);
        //     }
        // }

        $res=$this->affaireService->save($request);
        if(!is_null($res) ){
            if ($request->hasfile('filenames')) {
                $path = 'business/business' . $res->REF;
                $this->saveFileService->saveFiles($path,$request->file('filenames'));

            }
            $response=AffaireResponse::make($res);
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            return response()->json(["error"=>"Affaire Not Created"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
       $affaire=$this->affaireService->show($id);
       if(!is_null($affaire) ){
            $response= AffaireResponse::make($affaire);
            return response()->json(['data'=>$response],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(AffaireRequest $request, $id)
    {
        // $longitude = $request->input('longitude');
        // $latitude = $request->input('latitude');
        // if (!empty($longitude) || !empty($latitude)) {
        //     $validator = Validator::make($request->all(), [
        //         'longitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        //         'latitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        //     ]);
            // if ($validator->fails()) {
            //     return response($validator->errors(),Response::HTTP_BAD_REQUEST);
            // }
        // }

        // $ttc = $request->input('ttc');
        // if (!empty($ttc)) {
        //     $validator = Validator::make($request->all(), [
        //         'ttc' => 'in:0,1',
        //     ]);
        //     if ($validator->fails()) {
        //         return response($validator->errors(),Response::HTTP_BAD_REQUEST);
        //     }
        // }

        $res=$this->affaireService->update($request,$id);
        if(!is_null($res) ){
            $response=AffaireResponse::make($res);
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            return response()->json(["error"=>"Affaire Not Created"],Response::HTTP_BAD_REQUEST);
        }
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
        $res=$this->affaireService->destroy($request);
        if(!is_null($res) ){
            return response()->json($res,Response::HTTP_CREATED);
        }else{
            return response()->json(["error"=>"Affaire Not Created"],Response::HTTP_BAD_REQUEST);
        }
    }
}
