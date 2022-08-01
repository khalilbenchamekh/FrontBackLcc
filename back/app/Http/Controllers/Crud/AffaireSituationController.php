<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\AffaireSituationRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\AffaireSituation;
use App\Response\AffaireSituation\AffaireSituationResponse;
use App\Response\AffaireSituation\AffaireSituationsResponse;
use App\Services\AffaireSituation\IAffaireSituationService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AffaireSituationController extends Controller
{
    private $affaireSituationService;
    public function __construct(IAffaireSituationService $affaireSituationService)
    {
        $this->affaireSituationService=$affaireSituationService;
//        $this->middleware('role:affairesituations_create|owner|admin', ['only' => ['store', 'storeMany']]);
//        $this->middleware('role:affairesituations_edit|owner|admin', ['only' => ['update']]);
//        $this->middleware('role:affairesituations_read|owner|admin', ['only' => ['index']]);
//        $this->middleware('role:affairesituations_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $validator=Validator::make($request->all(),[
           "page"=>"required|integer"
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
        }
        $page=$request->input("page");
        $affaireSatuations=$this->affaireSituationService->index($page);
        if($affaireSatuations instanceof LengthAwarePaginator ){
            $response=AffaireSituationsResponse::make($affaireSatuations);
            return response()->json([
                'affaireSituations'=>$response->items(),
                "total"=>$affaireSatuations->total(),
                "currentPage"=>$affaireSatuations->currentPage(),
                "lastPage"=>$affaireSatuations->lastPage()
            ],Response::HTTP_OK);
        }
        return \response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);
//        $affairesituations = AffaireSituation::latest()->get();
//
//        return response(['data' => $affairesituations], 200);
    }

    public function storeMany(Request $request)
    {
       // $affairesituations = new AffaireSituation();
        $validator = Validator::make($request->all(), [
            'affaireSituations.*.Name' => 'required|string|min:4|max:255|distinct|unique:App\Models\AffaireSituation',
            'affaireSituations.*.orderChr' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $data=$request->all()['affaireSituations'];
        $affaireSituations=$this->affaireSituationService->storeMany($data);
        if(is_array($affaireSituations) && count($affaireSituations)>0){
            $response=AffaireSituationsResponse::make($affaireSituations);
            return  response()->json(["affaireSituations"=>$response],Response::HTTP_CREATED);
        }
        return \response()->json(['error'=>"Bad Request",Response::HTTP_BAD_REQUEST]);

//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $affaires = $request->all();
//        $affaire_records = [];
//        foreach ($affaires as $affaire) {
//            if (!empty($affaire)) {
//                $affairesituations->Name = $affaire['Name'];
//                $affairesituations->orderChr = $affaire['orderChr'];
//                $affairesituations->save();
//                $subject = LogsEnumConst::Add . LogsEnumConst::BusinessSituation . $affaire['Name'];
//           $logs = new LogActivity();
//        $logs->addToLog($subject, $request);
//                $affaire_records[] = $affairesituations;
//            }
//        }
//        $affairesituations = $affaire_records;
//        return response(['data' => $affairesituations], 201);


    }

    public function store(AffaireSituationRequest $request)
    {
        $affairesituation=$this->affaireSituationService->store($request->all());
        if($affairesituation instanceof AffaireSituation){
           $response=AffaireSituationResponse::make($affairesituation);
           return response()->json(["affaireSituation"=>$response],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);

//        $affairesituation = AffaireSituation::create($request->all());
//
//        return response(['data' => $affairesituation], 201);

    }

    public function show($id)
    {
        $affairesituation=$this->affaireSituationService->get($id);
        if($affairesituation instanceof AffaireSituation){
            $response=AffaireSituationResponse::make($affairesituation);
            return response()->json(["affaireSituation"=>$response],Response::HTTP_OK);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
//        $affairesituation = AffaireSituation::findOrFail($id);
//
//        return response(['data', $affairesituation], 200);
    }

    public function update(AffaireSituationRequest $request, $id)
    {
        $perAffaireSituation=$this->affaireSituationService->get($id);
        if($perAffaireSituation instanceof  AffaireSituation){
            $affairesituation=$this->affaireSituationService->edit($perAffaireSituation,$request->all());
            if($affairesituation instanceof AffaireSituation){
                $response=AffaireSituationResponse::make($affairesituation);
                return response()->json(["affaireSituation"=>$response],Response::HTTP_OK);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json(['error'=>"User Not Found"],Response::HTTP_BAD_REQUEST);
        }



//        $affairesituation = AffaireSituation::findOrFail($id);
//        $affairesituation->update($request->all());
//
//        return response(['data' => $affairesituation], 200);
    }

    public function destroy($id)
    {
        $perAffaireSitution=$this->affaireSituationService->get($id);
        if($perAffaireSitution instanceof  AffaireSituation){
            $affaireSituation=$this->affaireSituationService->delete($perAffaireSitution,$id);
            if($affaireSituation){
                $response=AffaireSituationResponse::make($perAffaireSitution);
                return response()->json(['affaireSituation'=>$response],Response::HTTP_OK);
            }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['error'=>"User Not Found"],Response::HTTP_BAD_REQUEST);
//        AffaireSituation::destroy($id);
//
//        return response(['data' => null], 204);
    }
}
