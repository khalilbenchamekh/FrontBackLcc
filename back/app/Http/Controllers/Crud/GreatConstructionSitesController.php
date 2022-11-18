<?php

namespace App\Http\Controllers\Crud;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\GreatConstructionSitesRequest;
use App\Response\GreatConstructionSites\GreatConstructionSitesResponse;
use App\Services\Fees\IFeesService;
use App\Services\GreatConstructionSites\IGreatConstructionSitesService;
use App\Services\SaveFile\ISaveFileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GreatConstructionSitesController extends Controller
{
    private $iGreatConstructionSitesService;
    private $saveFileService;
    private $iFeesService;
    public function __construct(IGreatConstructionSitesService $iGreatConstructionSitesService,ISaveFileService $saveFileService,IFeesService $iFeesService)
    {
        set_time_limit(8000000);
        $this->middleware('role:GreatConstructionSites_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:GreatConstructionSites_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:GreatConstructionSites_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:GreatConstructionSites_delete|owner|admin', ['only' => ['destroy']]);
        $this->iGreatConstructionSitesService = $iGreatConstructionSitesService;
        $this->saveFileService = $saveFileService;
        $this->iFeesService = $iFeesService;
    }

    public function dashboard(Request $request)
    {

        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        if (!empty($from) || !empty($to)) {

            $validator = Validator::make($request->all(), [
                'from' => 'date_format:Y/m/d',
                'to' => 'date_format:Y/m/d',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }

        if (!empty($orderBy)) {
            $validator = Validator::make($request->all(), [
                'orderBy' => 'in:year,month',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $orderBy = 'year';
        }

        $res = $this->iGreatConstructionSitesService->dashboard($from,$to,$orderBy);
        return response(['data' => $res],Response::HTTP_BAD_REQUEST);
    }


    public function index()
    {
        $res = $this->iGreatConstructionSitesService->index();
        return response(['data' => $res],Response::HTTP_BAD_REQUEST);
    }

    public function store(GreatConstructionSitesRequest $request)
    {
        $ttc = $request->input('ttc');
        if (!empty($ttc)) {
            $validator = Validator::make($request->all(), [
                'ttc' => 'in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        }else{
            $ttc = 0;
        }
        $allocated_brigades = $request->input('allocated_brigades');
        $Market_title = $request->input('Market_title');
        $arrayToReturend = explode(',', $allocated_brigades);
        $greatconstructionsites = $this->iGreatConstructionSitesService->store($request);
        if (!empty($arrayToReturend)) {
            $bus_mang = $this->iGreatConstructionSitesService->storeBusinessManagement($ttc,$greatconstructionsites);
            if ($request->hasfile('Execution_report')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/Execution_report';
                $this->saveFileService->saveFiles($direction,$request->file('Execution_report'));
            }
             if ($request->hasfile('Class_service')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/Class_service';
                $this->saveFileService->saveFiles($direction,$request->file('Class_service'));
            }
             if ($request->hasfile('filenames')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/fees';
                $this->saveFileService->saveFeesFiles($bus_mang,$direction,$request->file('filenames'));
                $this->iFeesService->saveGreatConstructionSitesFees($request,$bus_mang->id);
            }
            $res = $this->iGreatConstructionSitesService->storeAllocatedBrigade($request->all(),$greatconstructionsites,$arrayToReturend);
            if(!is_null($res)){
                $response= GreatConstructionSitesResponse::make($res);
                return response()->json([
                    "data"=>$response
                ],Response::HTTP_CREATED);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        } else {
            return response(['error' => 'allocated_brigades cannot be empty'], 400);
        }
    }

    public function show($id)
    {
        $res= $this->iGreatConstructionSitesService->show($id);
        if (!is_null($res)) {
            $response = GreatConstructionSitesResponse::make($res);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function update(GreatConstructionSitesRequest $request, $id)
    {
        $ttc = $request->input('ttc');
        if (!empty($ttc)) {
            $validator = Validator::make($request->all(), [
                'ttc' => 'in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        }else{
            $ttc = 0;
        }
        $allocated_brigades = $request->input('allocated_brigades');
        $Market_title = $request->input('Market_title');
        $arrayToReturend = explode(',', $allocated_brigades);
        $greatconstructionsites = $this->iGreatConstructionSitesService->store($request);
        if (!empty($arrayToReturend)) {
            $bus_mang = $this->iGreatConstructionSitesService->storeBusinessManagement($ttc,$greatconstructionsites);
            if ($request->hasfile('Execution_report')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/Execution_report';
                $this->saveFileService->saveFiles($direction,$request->file('Execution_report'));
            }
             if ($request->hasfile('Class_service')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/Class_service';
                $this->saveFileService->saveFiles($direction,$request->file('Class_service'));
            }
             if ($request->hasfile('filenames')) {
                $direction = 'GreatConstructionSites/' . $Market_title . '/fees';
                $this->saveFileService->saveFeesFiles($bus_mang,$direction,$request->file('filenames'));
                $this->iFeesService->saveGreatConstructionSitesFees($request,$bus_mang->id);
            }
            $res = $this->iGreatConstructionSitesService->updateAllocatedBrigade($request->all(),$greatconstructionsites,$arrayToReturend);
            if(!is_null($res)){
                $response= GreatConstructionSitesResponse::make($res);
                return response()->json([
                    "data"=>$response
                ],Response::HTTP_CREATED);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        } else {
            return response(['error' => 'allocated_brigades cannot be empty'], 400);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "Market_title"=>["required","string"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->iGreatConstructionSitesService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
