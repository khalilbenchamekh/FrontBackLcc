<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Crud\ChargesRequest;
use App\Response\Charge\ChargeResponse;
use App\Response\TypesCharge\TypesChargesResponse;
use App\Services\Charge\IChargeService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ChargesController extends Controller
{
    private $iChargeService;
    private $saveFileService;
    public function __construct(IChargeService $iChargeService,ISaveFileService $saveFileService)
    {
        $this->saveFileService = $saveFileService;
        $this->iChargeService = $iChargeService;
        set_time_limit(8000000);
        $this->middleware('role:charges_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:charges_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:charges_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:charges_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(PaginationRequest $request)
    {
        $affaireSatuations=$this->iChargeService->index($request);
        if($affaireSatuations instanceof LengthAwarePaginator ){
            $response=TypesChargesResponse::make($affaireSatuations);
            return response()->json([
                'data'=>$response->items(),
                "total"=>$affaireSatuations->total(),
                "currentPage"=>$affaireSatuations->currentPage(),
                "lastPage"=>$affaireSatuations->lastPage()
            ],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);
    }

    public function store(ChargesRequest $request)
    {
        $res=$this->iChargeService->store($request);
        if(!is_null($res) ){
            $response = ChargeResponse::make($res);
            if($request->hasFile('filenames')){
                $path = 'Load/' . $res->num_quit;
                $this->saveFileService->saveFiles($path,$request->file('filenames'));
            }
                return response()->json(["data"=>$response],Response::HTTP_CREATED);
        }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $res=$this->iChargeService->show($id);
        if(!is_null($res) ){
            $response = ChargeResponse::make($res);
             return response()->json(['data'=>$response],Response::HTTP_OK);
         }else{
             return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
         }
    }

    public function update(ChargesRequest $request, $id)
    {
        $res=$this->iChargeService->update($id,$request);
        if(! is_null($res)){
            if($request->hasFile('filenames')){
                /// we must create a response ChargeResponse + ChargesResponse  $response=ChargeResponse::make($res);
                $path = 'Load/' . $res->num_quit;
                $this->saveFileService->saveFiles($path,$request->file('filenames'));
            }
            return response()->json(["data"=>$res],Response::HTTP_CREATED);
        }

        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "num_quit"=>["required","string"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $res=$this->iChargeService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
}
