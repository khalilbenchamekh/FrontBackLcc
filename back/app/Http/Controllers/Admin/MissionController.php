<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MissionRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use Illuminate\Http\Request;
use App\Response\Mission\MissionResponse;
use App\Response\Mission\MissionsResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Mission\IMissionService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class MissionController extends Controller
{
    private $iMissionService;
    public function __construct(IMissionService $iMissionService)
    {
        $this->middleware('role:Mission_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:Mission_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:Mission_read|owner|admin', ['only' => ['index']]);
       $this->middleware('role:Mission_delete|owner|admin', ['only' => ['destroy']]);
        $this->iMissionService = $iMissionService;
    }

    public function index(PaginationRequest $request)
    {
        $res = $this->iMissionService->index($request->all());
       if($res instanceof LengthAwarePaginator){
            $response=MissionsResponse::make($res);
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

    public function store(MissionRequest $request)
    {
        $allDay = $request->input('allDay');
        if(!empty($allDay)){
            $validator = Validator::make($request->all(), [
                'allDay' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),400);
            }
        }else{
            $request['allDay'] = 0;
        }

        $res=$this->iMissionService->save($request->all());
        if(!is_null($res) ){
           $response=MissionResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $res=$this->iMissionService->show($id);
        if(!is_null($res) ){
             $response= MissionResponse::make($res);
             return response()->json(['data'=>$response],Response::HTTP_OK);
         }
         return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
    }

    public function update(MissionRequest $request, $id)
    {
        $allDay = $request->input('allDay');
        if(!empty($allDay)){

            $validator = Validator::make($request->all(), [
                'allDay' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(),400);
            }
        }else{
            $request['allDay'] = 0;
        }

        $res=$this->iMissionService->update($request->all(),$id);
        if(!is_null($res) ){
           $response=MissionResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function getMissionOfUSer($id)
    {
        $res=$this->iMissionService->getMissionOfUSer($id);
        if(!is_null($res) ){
           $response=MissionResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "text"=>["required","string"]
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
            $res=$this->iMissionService->destroy($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }else{
               return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
           }
    }
}
