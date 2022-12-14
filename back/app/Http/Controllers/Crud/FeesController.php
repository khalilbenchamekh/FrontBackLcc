<?php
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Response\Affaire\AffairesResponse;
use App\Response\Fees\FeesResponse;
use App\Response\Fees\FeessResponse;
use App\Services\Affaire\IAffaireService;
use App\Services\Fees\IFeesService;
use App\Services\FolderTech\IFolderTechService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class FeesController extends Controller
{
    private $iFeesService;
    private $iFolderTechService;
    private $iAffaireService;
    private $saveFileService;
    public function __construct(IFeesService $iFeesService,IFolderTechService $iFolderTechService,IAffaireService $iAffaireService,ISaveFileService $saveFileService)
    {
        set_time_limit(8000000);
        $this->middleware('role:owner|admin');
        $this->middleware('role:fees_create|owner|admin', ['only' => ['saveBusinessFees', 'saveFolderTechFees']]);
        $this->middleware('role:fees_edit|owner|admin', ['only' => ['updateBusinessFees', 'updateFolderTechFees']]);
        $this->iFeesService=$iFeesService;
        $this->iFolderTechService=$iFolderTechService;
        $this->iAffaireService=$iAffaireService;
        $this->saveFileService=$saveFileService;
    }
    public function getFolderTech(PaginationRequest $request)
    {
        $folderTech = $this->iFolderTechService->getFolderTech($request->all());
        if($folderTech instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($folderTech);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],
            Response::HTTP_OK
            );
        }
         return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);

    }

    public function getBusiness(PaginationRequest $request)
    {
        $business = $this->iAffaireService->getBusiness($request->all());
        if($business instanceof  LengthAwarePaginator ){
            $response= AffairesResponse::make($business);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFolderTechFees(PaginationRequest $request)
    {
        $fees = $this->iFeesService->getFolderTechFees($request);
        if($fees instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($fees);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getBusinessFees(PaginationRequest $request)
    {
        $fees = $this->iFeesService->getBusinessFees($request->all());
        if($fees instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($fees);
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function saveBusinessFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $res=$this->iFeesService->saveBusinessFees($request->all());
        if(!is_null($res) ){
            $business = $this->iAffaireService->show($id);
            $path = 'Fees/' . $business->REF;
            $this->saveFileService->saveFeesFiles($res,$path,$request->file('filenames'));
            $response=FeesResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function saveFolderTechFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'required|string|max:255',
            'id' => 'required',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $id = $request->input('id');
        $res=$this->iFeesService->saveFolderTechFees($request->all());
        if(!is_null($res) ){
            $business = $this->iAffaireService->show($id);
            $path = 'Fees/' . $business->REF;
            $this->saveFileService->saveFeesFiles($res,$path,$request->file('filenames'));
            $response=FeesResponse::make($res);
           return response()->json($response,Response::HTTP_CREATED);
       }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function updateBusinessFees(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $fees=$this->iFeesService->updateBusinessFees($request,$id);
        if(!is_null($fees) ){
            $business = $this->iAffaireService->show($id);
            $path = 'Fees/' . $business->REF;
            $this->saveFileService->saveFeesFiles($fees,$path,$request->file('filenames'));
            $response=FeesResponse::make($fees);
            return response()->json($response,Response::HTTP_CREATED);
        }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function updateFolderTechFees(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'required',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $fees=$this->iFeesService->updateFolderTechFees($request,$id);
        if(!is_null($fees) ){
            $business = $this->iAffaireService->show($id);
            $path = 'Fees/' . $business->REF;
            $this->saveFileService->saveFeesFiles($fees,$path,$request->file('filenames'));
            $response=FeesResponse::make($fees);
            return response()->json($response,Response::HTTP_CREATED);
        }
       return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

}
