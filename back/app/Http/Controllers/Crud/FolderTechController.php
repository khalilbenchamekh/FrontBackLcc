<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\FolderTechRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\BusinessManagement;
use App\Models\FolderTech;
use App\Models\Mission;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class FolderTechController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:foldertechnatures_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:foldertechnatures_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:foldertechnatures_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:foldertechnatures_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function index()
    {
        $folderteches = FolderTech::latest()->get();

        return response(['data' => $folderteches], 200);
    }

    public function store(FolderTechRequest $request)
    {
        $now = new DateTime();
        $year = $now->format("Y");
        $nature_name = $request->input('nature_name');
        $nature_Abr_v_name = $request->input('nature_Abr_v_name');
        $place = $request->input('place');
        $count = FolderTech::where('nature_name', '=', $nature_name)->count();
        $count++;
        $ref = $nature_Abr_v_name . $count . "_" . $place . "_" . $year;
        $affaire = new FolderTech();
        $affaire->REF = $ref;
        $affaire->PTE_KNOWN = $request->input('PTE_KNOWN');
        $affaire->TIT_REQ = $request->input('TIT_REQ');
        $affaire->place = $request->input('place');
        $affaire->DATE_ENTRY = $request->input('DATE_ENTRY');
        $affaire->DATE_LAI = $request->input('DATE_LAI');
        $affaire->UNITE = $request->input('UNITE');
//        $affaire->ARCHIVE=$request->input('ARCHIVE');
//        $affaire->isValidate=$request->input('isValidate');
//        $affaire->isPayed=$request->input('isPayed');
        $affaire->PRICE = $request->input('PRICE');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->folder_sit_id = $request->input('aff_sit_id');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->client_id = $request->input('client_id');
        $affaire->resp_id = $request->input('resp_id');
        $affaire->nature_name = $request->input('nature_name');
        $affaire->save();

        $bus_mang = new BusinessManagement();
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        if (!empty($longitude) || !empty($latitude)) {

            $validator = Validator::make($request->all(), [
                'longitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
                'latitude' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
            $bus_mang->longitude = $longitude;
            $bus_mang->latitude = $latitude;
        }
        $ttc = $request->input('ttc');
        if (!empty($ttc)) {
            $validator = Validator::make($request->all(), [
                'ttc' => 'in:0,1',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
            $bus_mang->ttc = $ttc;
        }
        if ($request->hasfile('filenames')) {
            $filesArray = [
                'geoMapping',
                'geoMapping/Dossier Technique',
                'geoMapping/Dossier Technique/Dossier Technique',
            ];
            $pathToMove = 'geoMapping/Dossier Technique/Dossier Technique' . $ref;
            array_push($filesArray, $pathToMove);
            foreach ($filesArray as $item) {
                $path = public_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }

            foreach ($request->file('filenames') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = md5($filename . time()) . '.' . $extension;
                $path = public_path() . '/' . $pathToMove;
                $file->move($path, $fileNameToStore);
            }
        }

        $bus_mang->membership()->associate($affaire);
        $bus_mang->save();
        $mission = new Mission();
        $mission->text = "Dossier Technique" . $ref;
        $mission->description = "";
        $mission->startDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->endDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->allDay = 1;
        $mission->save();

        $subject = LogsEnumConst::Add . LogsEnumConst::FolderTech . $ref;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $affaire], 201);

    }

    public function show($id)
    {
        $foldertech = FolderTech::findOrFail($id);

        return response(['data', $foldertech], 200);
    }

    public function update(FolderTechRequest $request, $id)
    {
        $foldertech = FolderTech::findOrFail($id);
        $foldertech->update($request->all());
        $subject = LogsEnumConst::Update . LogsEnumConst::FolderTech . $foldertech->REF;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $foldertech], 200);
    }

    public function destroy($id)
    {
        FolderTech::destroy($id);

        return response(['data' => null], 204);
    }
}
