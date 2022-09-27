<?php
namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberShipType;
use App\Models\Affaire;
use App\Models\File as FeesFile;
use App\Models\BusinessManagement;
use App\Models\Fees;
use App\Models\FolderTech;
use App\Response\Affaire\AffairesResponse;
use App\Response\Fees\FeesResponse;
use App\Response\Fees\FeessResponse;
use App\Services\Affaire\IAffaireService;
use App\Services\Fees\IFeesService;
use App\Services\FolderTech\IFolderTechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class FeesController extends Controller
{
    private $iFeesService;
    private $iFolderTechService;
    private $iAffaireService;
    public function __construct(IFeesService $iFeesService,IFolderTechService $iFolderTechService,IAffaireService $iAffaireService)
    {
        // set_time_limit(8000000);
        // $this->middleware('role:owner|admin');
        // $this->middleware('role:fees_create|owner|admin', ['only' => ['saveBusinessFees', 'saveFolderTechFees']]);
        // $this->middleware('role:fees_edit|owner|admin', ['only' => ['updateBusinessFees', 'updateFolderTechFees']]);
        $this->iFeesService=$iFeesService;
        $this->iFolderTechService=$iFolderTechService;
        $this->iAffaireService=$iAffaireService;
    }

    public function getFolderTech(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $folderTech = $this->iFolderTechService->getFolderTech($request->all());
        if($folderTech instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($folderTech);
            return response()->json([
                'folderTech'=>$response->items(),
                'total'=>$folderTech->total(),
                'lastPage'=>$folderTech->lastPage(),
                'currentPage'=>$folderTech->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $business = $this->iAffaireService->getBusiness($request->all());
        if($business instanceof  LengthAwarePaginator ){
            $response= AffairesResponse::make($business);
            return response()->json([
                'Affaires'=>$response->items(),
                'total'=>$business->total(),
                'lastPage'=>$business->lastPage(),
                'currentPage'=>$business->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFolderTechFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $fees = $this->iFeesService->getFolderTechFees($request);
        if($fees instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($fees);
            return response()->json([
                'FolderTechFees'=>$response->items(),
                'total'=>$fees->total(),
                'lastPage'=>$fees->lastPage(),
                'currentPage'=>$fees->currentPage(),
            ],
            Response::HTTP_OK
            );
        }else{
            return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
        }
    }

    public function getBusinessFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>'required|integer',
            "page"=>'required|integer'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $fees = $this->iFeesService->getBusinessFees($request->all());
        if($fees instanceof  LengthAwarePaginator ){
            $response= FeessResponse::make($fees);
            return response()->json([
                'businessFees'=>$response->items(),
                'total'=>$fees->total(),
                'lastPage'=>$fees->lastPage(),
                'currentPage'=>$fees->currentPage(),
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
            'id' => 'required|exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)->where('membership_type', 'like', '%' . "Affaire")->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang[0]->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('advanced');
            $fees = new Fees();
            $fees->businessManagement()->associate(
                $busines_mang_id
            );
            $fees->price = $price;
            $fees->observation = $observation;
            $fees->type = MemberShipType::business;
            $fees->advanced = $advanced;
            $fees->save();
            $business = Affaire::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }
                foreach ($request->file('filenames') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

    public function saveFolderTechFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'required|string|max:255',
            'id' => 'required|exists:folderteches,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $fees=$this->iFeesService->saveFolderTechFees($request);
        if($fees instanceof Fees){
            $response=FeesResponse::make($fees);
            return response()->json($response,Response::HTTP_CREATED);
        }
        if($fees instanceof BusinessManagement){

        }
        return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }

    public function updateBusinessFees(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $fees=$this->iFeesService->updateBusinessFees($request,$id);
        dd($fees);
        if($fees instanceof Fees){
            $response=FeesResponse::make($fees);
            return response()->json($response,Response::HTTP_CREATED);
        }
        if($fees instanceof BusinessManagement){

        }
    }

    public function updateFolderTechFees(Request $request, $index)
    {
        $validator = Validator::make($request->all(), [
            'advanced' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'observation' => 'string|max:255',
            'id' => 'exists:affaires,id',
            '*.filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
            'filenames.*' => 'mimes:jpeg,png,gif,svg,doc,pdf,docx,zip',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $busines_mang = BusinessManagement::where("membership_id", '=', $id)
        ->where("membership_type", 'like', MemberShipType::folderTech)->get();
        $size = count($busines_mang);
        if ($size > 0) {
            $busines_mang_id = $busines_mang->id;
            $price = $request->input('price');
            $observation = $request->input('observation');
            $advanced = $request->input('id');
            $fees = Fees::findOrFail($index);
            $fees->update([
                'price' => $price,
                'observation' => $observation,
                'type' => MemberShipType::folderTech,
                'business_id' => $busines_mang_id,
                'advanced' => $advanced,
            ]);
            $business = FolderTech::findOrFail($id);
            if ($request->hasfile('filenames')) {
                $filesArray = [
                    'geoMapping',
                    'geoMapping/Fees',
                ];
                $pathToMove = 'geoMapping/Fees/' . $business->REF;
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }
                foreach ($request->file('filenames') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);
                    $fileModel = new FeesFile();
                    $fileModel->businessManagement()->associate(
                        $busines_mang_id
                    );
                    $fileModel->filename = $path . '/' . $name;
                    $fileModel->save();
                }
                array_pop($filesArray);
            }
            return response(['data' => $fees], 200);

        } else {
            return response(['data' => $busines_mang], 200);
        }
    }

}
