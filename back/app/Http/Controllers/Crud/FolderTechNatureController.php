<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FolderTechNatureRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Requests\Enums\OperationChoice;
use App\Models\FolderTechNature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FolderTechNatureController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:folderteches_create|owner|admin', ['only' => ['storeMany']]);
        $this->middleware('role:folderteches_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:folderteches_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:folderteches_delete|owner|admin', ['only' => ['destroy']]);
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
    public function index()
    {
        $foldertechnatures = FolderTechNature::latest()->get();

        return response(['data' => $foldertechnatures], 200);
    }
    public function storeMany(Request $request)
    {

        $validator = Validator::make($request->all(), [
            '*.Name' => 'required|string|min:4|max:255|distinct|unique:App\Models\FolderTechNature',
            '*.Abr_v' => 'string|max:3',
        ]);

        if($validator->fails()) {
            return response($validator->errors(),400);
        }
        $operation = OperationChoice::MULTIPLE;
        return  $this->treatment($request,$operation ,null);

    }
    public function store(FolderTechNatureRequest $request)
    {
        $operation = OperationChoice::SAVE;
        return  $this->treatment($request,$operation ,null);

    }

    public function show($id)
    {
        $foldertechnature = FolderTechNature::findOrFail($id);

        return response(['data', $foldertechnature], 200);
    }

    public function update(FolderTechNatureRequest $request, $id)
    {
        $operation = OperationChoice::UPDATE;
        return  $this->treatment($request,$operation,$id);
    }

    public function destroy($id)
    {
        FolderTechNature::destroy($id);

        return response(['data' => null], 204);
    }
}
