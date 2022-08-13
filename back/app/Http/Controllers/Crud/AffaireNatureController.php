<?php
namespace App\Http\Controllers\Crud;
use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PaginatinRequest;
use App\Http\Requests\Crud\AffaireNatureArrayRequest;
use App\Http\Requests\Crud\AffaireNatureRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Requests\Enums\OperationChoice;
use App\Models\AffaireNature;
use App\Response\AffaireNature\AffaireNatureResponse;
use App\Response\AffaireNature\AllAffaireNatureResponse;
use App\Services\AffaireNature\IAffaireNatureService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

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

    public function index(PaginatinRequest $request)
    {
        $affairenatures=$this->affaireNatureService->getAllAffaireNature($request);
        if($affairenatures instanceof  LengthAwarePaginator ){
            $response= AllAffaireNatureResponse::make($affairenatures->items());
            return response()->json([
                'affairenatures'=>$response,
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
        $affaireNature=$this->affaireNatureService->store($request);
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
            return response()->json(['affaireNature'=>$response],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function edait($id,AffaireNatureRequest $request)
    {
        $affaireNature=$this->affaireNatureService->edit($id,$request->all());
        if($affaireNature===true){
            return response()->json(['errors'=>"Name exist"],Response::HTTP_BAD_REQUEST);
        }
        if ($affaireNature instanceof AffaireNature){
            $response= AffaireNatureResponse::make($affaireNature);
            return response()->json(['affaireNature'=>$response],Response::HTTP_OK);
        }else{
            return response()->json(['error'=>"Bad Requedt"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function storeMany(AffaireNatureArrayRequest $request)
    {
        $affaires = $request->all()["affaires"];
        $saveManyAffaires= $this->affaireNatureService->saveMany($affaires);
        return response()->json(["affaires"=>$saveManyAffaires],Response::HTTP_CREATED);
    }

    private function treatment(Request $request, String $choice, $extera)
    {

        $affairenature = new AffaireNature();
        $name = $request->input('Name');
        $abr_v = $request->input('Abr_v');
        $abr_v = empty($abr_v) ? substr($name, 0, 3) : $abr_v;
        $affairenature->Name = $name;
        $affairenature->Abr_v = $abr_v;
        if ($choice == OperationChoice::SAVE) {
            $subject = LogsEnumConst::Add . LogsEnumConst::BusinessNature . $abr_v;
       $logs = new LogActivity();
        $logs->addToLog($subject, $request);
            $affairenature->save();
        }
        if ($choice == OperationChoice::UPDATE) {
            $affairenature = AffaireNature::findOrFail($extera);
            $affairenature->update(
                array('Name' => $name, 'Abr_v' => $abr_v)
            );

            $subject = LogsEnumConst::Update . LogsEnumConst::BusinessNature . $abr_v;
       $logs = new LogActivity();
        $logs->addToLog($subject, $request);

        }
        if ($choice == OperationChoice::MULTIPLE) {
            $affaires = $request->all();
            $affaire_records = [];
            foreach ($affaires as $affaire) {
                if (!empty($affaire)) {
                    $affairenature->Name = $affaire['Name'];
                    $affairenature->Abr_v = $affaire['Abr_v'];
                    $affairenature->save();
                    $affaire_records[] = $affairenature;
                    $subject = LogsEnumConst::Add . LogsEnumConst::BusinessNature . $affaire['Abr_v'];
               $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                }
            }
            $affairenature = $affaire_records;
        }

        return response(['data' => $affairenature], $choice === OperationChoice::SAVE ? 201 : 200);


    }

    public function show($id)
    {
        $affairenature = AffaireNature::findOrFail($id);

        return response(['data', $affairenature], 200);
    }

    public function update(AffaireNatureRequest $request, $id)
    {
        $operation = OperationChoice::UPDATE;
        return $this->treatment($request, $operation, $id);
    }

    public function destroy($id)
    {
        //AffaireNature::destroy($id);
        $affaire=$this->affaireNatureService->destroy($id);
        if($affaire instanceof AffaireNature){
             return response()->json(['data' => true], Response::HTTP_NO_CONTENT);
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }
}
