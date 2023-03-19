<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FolderTechNatureManyRequest;
use App\Http\Requests\Pagination\PaginationRequest;
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
        set_time_limit(8000000);
        $this->middleware('role:folderteches_create|owner|admin', ['only' => ['storeMany']]);
        $this->middleware('role:folderteches_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:folderteches_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:folderteches_delete|owner|admin', ['only' => ['destroy']]);
        $this->iFolderTechNatureService = $iFolderTechNatureService;
    }

    public function index(PaginationRequest $request)
    {
        $foldertechnatures = $this->iFolderTechNatureService->index($request->all());
        if ($foldertechnatures instanceof LengthAwarePaginator) {
            $response = FolderTechNaturesResponse::make($foldertechnatures->items());
            return response()->json([
                "data" => $response,
                'countPage' => $foldertechnatures->perPage(),
                "currentPage" => $foldertechnatures->currentPage(),
                "nextPage" => $foldertechnatures->currentPage() < $foldertechnatures->lastPage() ? $foldertechnatures->currentPage() + 1 : $foldertechnatures->currentPage(),
                "lastPage" => $foldertechnatures->lastPage(),
                'total' => $foldertechnatures->total(),
            ], Response::HTTP_OK);
        } else {
            return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
        }
    }
    public function storeMany(FolderTechNatureManyRequest $request)
    {
        $foldertechnatures = $this->iFolderTechNatureService->storeMany($request);
        if (is_array($foldertechnatures) && !empty($foldertechnatures)) {
            $response = FolderTechNaturesResponse::make($foldertechnatures);
            return response()->json([
                "data" => $response
            ], Response::HTTP_CREATED);
        }
        return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }
    public function store(FolderTechNatureRequest $request)
    {
        $foldertechnature = $this->iFolderTechNatureService->save($request);
        if ($foldertechnature instanceof FolderTechNature) {
            $response = FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "data" => $response
            ], Response::HTTP_CREATED);
        }
        return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        $foldertechnature = $this->iFolderTechNatureService->show($id);
        if ($foldertechnature instanceof FolderTechNature) {
            $response = FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "data" => $response
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function update(FolderTechNatureRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|min:4|max:255',
            'Abr_v' => 'string|max:3',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $foldertechnature = $this->iFolderTechNatureService->update($id, $request);
        if ($foldertechnature instanceof FolderTechNature) {
            $response = FolderTechNatureResponse::make($foldertechnature);
            return response()->json([
                "data" => $response
            ], Response::HTTP_OK);
        }
        if ($foldertechnature === true) {
            return response()->json(['error' => "Name already exist"], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "integer"],
            "Abr_v" => ["required", "string"]
        ]);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        $res = $this->iFolderTechNatureService->destroy($request);
        if (!is_null($res)) {
            $response = FolderTechNatureResponse::make($res);
            return response()->json(['data' => $response], Response::HTTP_OK);
        }
        return response()->json(['error' => "Bad Request"], Response::HTTP_BAD_REQUEST);
    }
}
