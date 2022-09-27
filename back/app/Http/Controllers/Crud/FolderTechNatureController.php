<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FolderTechNatureRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Requests\Enums\OperationChoice;
use App\Models\FolderTechNature;
use App\Response\FolderTechNature\FolderTechNatureResponse;
use App\Response\FolderTechNature\FolderTechNaturesResponse;
use App\Services\FolderTechNature\IFolderTechNatureService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FolderTechNatureController extends Controller
{

    private $iFolderTechNatureService;
    public function __construct(IFolderTechNatureService $iFolderTechNatureService)
    {
        // set_time_limit(8000000);
        // $this->middleware('role:folderteches_create|owner|admin', ['only' => ['storeMany']]);
        // $this->middleware('role:folderteches_edit|owner|admin', ['only' => ['update']]);
        // $this->middleware('role:folderteches_read|owner|admin', ['only' => ['index']]);
        // $this->middleware('role:folderteches_delete|owner|admin', ['only' => ['destroy']]);
        $this->iFolderTechNatureService=$iFolderTechNatureService;
    }


    private function treatment(Request $request,String $choice,$extera){

        $affairenature = new FolderTechNature();
        $name= $request->input('Name');
        $abr_v= $request->input('Abr_v');
        $abr_v=empty($abr_v) ? substr($name,0,3) : $abr_v;
        $affairenature->Name=$name;
        $affairenature->Abr_v=$abr_v;
        if($choice == OperationChoice::SAVE){
            $affairenature->save();
            $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechNature . $abr_v;
       $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        }if($choice == OperationChoice::UPDATE){
            $affairenature = FolderTechNature::findOrFail($extera);

            $affairenature->update($request->all());
            $subject = LogsEnumConst::Update . LogsEnumConst::FolderTechNature . $abr_v;
       $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        }if($choice == OperationChoice::MULTIPLE) {
            $affaires = $request->all();
            $affaire_records = [];
            foreach($affaires as $affaire)
            {
                if(! empty($affaire))
                {

                    $affairenature->Name= $affaire['Name'];
                    $affairenature->Abr_v=$affaire['Abr_v'];
                    $affairenature->save();
                    $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechNature . $abr_v;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                    $affaire_records[] = $affairenature;

                }
            }
            $affairenature= $affaire_records;
        }

        return response(['data' => $affairenature ], $choice === OperationChoice::SAVE ? 201 : 200);


    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $foldertechnatures = $this->iFolderTechNatureService->index($request);
        if($foldertechnatures instanceof LengthAwarePaginator){
            $response= FolderTechNaturesResponse::make($foldertechnatures->all());
            return response()->json([
                'foldertechnatures'=>$response,
                'total'=>$foldertechnatures->total(),
                'lastPage'=>$foldertechnatures->lastPage(),
                'currentPage'=>$foldertechnatures->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
    public function storeMany(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'folderTechNature.*.Name' => 'required|string|min:4|max:255|distinct|unique:App\Models\FolderTechNature',
            'folderTechNature.*.Abr_v' => 'string|max:3',
        ]);

        if($validator->fails()) {
            return response($validator->errors(),400);
        }
        $foldertechnatures=$this->iFolderTechNatureService->storeMany($request);
        if(is_array($foldertechnatures) && !empty($foldertechnatures)){
            $response= FolderTechNaturesResponse::make($foldertechnatures);
            return response()->json([
                "folderTechNature"=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function store(FolderTechNatureRequest $request)
    {
        $foldertechnature=$this->iFolderTechNatureService->save($request);
        if($foldertechnature instanceof FolderTechNature){
            $response= FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "folderTechNature"=>$response
            ],Response::HTTP_CREATED);
        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $foldertechnature =$this->iFolderTechNatureService->show($id);
        if($foldertechnature instanceof FolderTechNature){
            $response= FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "folderTechNature"=>$response
            ],Response::HTTP_OK);
        }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|min:4|max:255',
            'Abr_v' => 'string|max:3',
        ]);

        if($validator->fails()) {
            return response($validator->errors(),400);
        }

        $foldertechnature =$this->iFolderTechNatureService->update($id,$request);
        if($foldertechnature instanceof FolderTechNature){
            $response= FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "folderTechNature"=>$response
            ],Response::HTTP_OK);
        }
        if($foldertechnature === true){
            return response()->json(['error'=>"Name alerdy teken"],Response::HTTP_BAD_REQUEST);
        }
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function destroy($id)
    {
        $feesfoldertech = $this->iFolderTechNatureService->destroy($id);

        if($feesfoldertech instanceof FolderTechNature){
             $response=FolderTechNatureResponse::make($feesfoldertech);
             return response()->json([
                 'feesfolderteche'=>$response
             ],Response::HTTP_OK);
         }else{
             return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
         }
    }
}
