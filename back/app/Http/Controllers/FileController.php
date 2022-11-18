<?php

namespace App\Http\Controllers;
use App\Http\Requests\Auth\PaginationRequest;
use App\Http\Requests\FileRequest;
use App\Models\File as FileModel;
use App\Response\FileModel\FileModelResponse;
use App\Response\FolderTechNature\FilesModelResponse;
use App\Service\File\IFileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use App\Services\SaveFile\ISaveFileService;


class FileController extends Controller
{
    private $saveFileService;
    private $iFileService;
    private function __construct(ISaveFileService $saveFileService,IFileService $iFileService){
        $this->saveFileService = $saveFileService;
        $this->iFileService = $iFileService;
    }
    public function index(PaginationRequest $request)
    {
        $res = $this->iFileService->index($request);
        if($res instanceof LengthAwarePaginator){
            $response = FilesModelResponse::make($res->all());
            return response()->json([
                "data"=>$response,
                'countPage'=>$response->perPage(),
                "currentPage"=>$response->currentPage(),
                "nextPage"=>$response->currentPage()<$response->lastPage()?$response->currentPage()+1:$response->currentPage(),
                "lastPage"=>$response->lastPage(),
                'total'=>$response->total(),
            ],Response::HTTP_OK);
        }
        return response()->json(["error"=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
    public function FileManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filename' => 'required|string|max:255',
            'type' => 'required|in:Profile,Messagerie',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $type = $request->input("type");
        $fileName = $request->input("filename");
        if ($type == "Profile") {
            $validator = Validator::make($request->all(), [
                'user_name' => 'exists:users,username',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        }

        $path =  $type . $type == "Profile" ?  "/"  . $request->input("user_name") . "/" : "/" . $fileName;
        $file = $this->saveFileService->downloadFile($path);
        return response()->download($file, $fileName);
    }

    public function store(Request $request)
    {
        request()->validate([
            '*.filename.*' => 'required|image|mimes:jpeg,png,jpg,gif,svgdoc,pdf,docx,zip',
        ]);
        if ($request->hasfile('filename')) {
            $files = $this->saveFileService->saveMany("files/",$request->file('filename'),'filename');
            $this->iFileService->store($files);
        }
        return response(['data' => 'Data Your files has been successfully added'], 201);
    }

    public function show($id)
    {
        $res= $this->iFileService->get($id);
        if (!is_null($res)) {
            $response = FileModelResponse::make($res);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }

    public function update(FileRequest $request, $id)
    {
        $file= $this->iFileService->get($id);
        $res= $this->iFileService->edit($file,$request);
        if (!is_null($res)) {
            $response = FileModelResponse::make($res);
            return response()->json(["data"=>$response],Response::HTTP_OK);
        }
        return response()->json("Bad Request",Response::HTTP_BAD_REQUEST);
    }
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "id"=>["required","integer"],
            "filename"=>["required"],
        ]);
            if($validator->fails()){
                return response()->json(["error"=>$validator->errors()],Response::HTTP_BAD_REQUEST);
            }
            $res=$this->iFileService->delete($request);
            if(!is_null($res) ){
                return response()->json(['data' => $res], Response::HTTP_NO_CONTENT);
           }
           return response()->json(['error'=>"Bad Request"],Response::HTTP_BAD_REQUEST);
    }
}
