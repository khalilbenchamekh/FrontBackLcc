<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FolderTechSituationRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\FolderTechSituation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderTechSituationController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:owner|admin');
        $this->middleware('role:foldertechsituations_create|owner|admin', ['only' => ['storeMany']]);
        $this->middleware('role:foldertechsituations_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:foldertechsituations_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:foldertechsituations_delete|owner|admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        $foldertechsituations = FolderTechSituation::latest()->get();

        return response(['data' => $foldertechsituations ], 200);
    }

    public function store(FolderTechSituationRequest $request)
    {
        $foldertechsituation = FolderTechSituation::create($request->all());

        return response(['data' => $foldertechsituation ], 201);

    }
    public function storeMany(Request $request)
    {
        $foldertechsituation =new FolderTechSituation();
        $validator = Validator::make($request->all(), [
            '*.Name' => 'required|string|min:4|max:255|distinct|unique:App\Models\FolderTechSituation',
            '*.orderChr' => 'integer|between:0,10',
        ]);

        if($validator->fails()) {
            return response($validator->errors(),400);
        }
        $affaires = $request->all();
        $affaire_records = [];
        foreach($affaires as $affaire)
        {
            if(! empty($affaire))
            {
                $foldertechsituation->Name= $affaire['Name'];
                $foldertechsituation->orderChr=$affaire['orderChr'];
                $foldertechsituation->save();
                $subject = LogsEnumConst::Add . LogsEnumConst::FolderTechSituation . $affaire['Name'];
           $logs = new LogActivity();
        $logs->addToLog($subject, $request);
                $affaire_records[] = $foldertechsituation;
            }
        }
        $foldertechsituation= $affaire_records;
        return response(['data' => $foldertechsituation ],  201);


    }

    public function show($id)
    {
        $foldertechsituation = FolderTechSituation::findOrFail($id);

        return response(['data', $foldertechsituation ], 200);
    }

    public function update(FolderTechSituationRequest $request, $id)
    {
        $foldertechsituation = FolderTechSituation::findOrFail($id);
        $foldertechsituation->update($request->all());
        $subject = LogsEnumConst::Update . LogsEnumConst::FolderTechSituation . $foldertechsituation['Name'];
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $foldertechsituation ], 200);
    }

    public function destroy($id)
    {
        FolderTechSituation::destroy($id);

        return response(['data' => null ], 204);
    }
}
