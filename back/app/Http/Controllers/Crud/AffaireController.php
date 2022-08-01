<?php

namespace App\Http\Controllers\Crud;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\AffaireRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\Affaire;
use App\Models\AffaireSituation;
use App\Models\BusinessManagement;
use App\Models\Mission;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AffaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:affaires_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:affaires_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:affaires_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:affaires_delete|owner|admin', ['only' => ['destroy']]);

    }

    public function index()
    {
        $affaires = Affaire::latest()->get();
        return response(['data' => $affaires], 200);
    }

    public function store(AffaireRequest $request)
    {
        $now = new DateTime();
        $year = $now->format("Y");
        $nature_name = $request->input('nature_name');
        $nature_Abr_v_name = $request->input('nature_Abr_v_name');
        $place = $request->input('place');
        $count = Affaire::where('nature_name', '=', $nature_name)->count();
        $count++;
        $ref = $nature_Abr_v_name.$count."_" . $place . "_" . $year;
        $affaire = new Affaire();
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
        $affaire->aff_sit_id = $request->input('aff_sit_id');
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
        if ($request->hasfile('filenames')) {
            $filesArray = [
                'geoMapping',
                'geoMapping/business',
                'geoMapping/business/business',
            ];
            $pathToMove = 'geoMapping/business/business' . $ref;
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
        $bus_mang->DATE_LAI = $request->input('DATE_LAI');
        $bus_mang->DATE_ENTRY = $request->input('DATE_ENTRY');
        $bus_mang->membership()->associate($affaire);
        $bus_mang->save();
        $mission = new Mission();
        $mission->text = "affaire" . $ref;
        $mission->description = "";
        $mission->startDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->endDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->allDay = 1;
        $mission->save();
        $subject = LogsEnumConst::Update . LogsEnumConst::Business . $affaire->REF;
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $affaire], 201);
    }

    public function show($id)
    {
        $affaire = Affaire::findOrFail($id);

        return response(['data', $affaire], 200);
    }

    public function update(AffaireRequest $request, $id)
    {
        $aff_sit_id = $request->input('aff_sit_id');
        $key_sit = AffaireSituation::where('id', '=', $aff_sit_id)->firstOrFail();

        $affaire = Affaire::where('REF', '=', $id)->firstOrFail();
        $user = Auth::user()->hasRole(['owner', 'admin']);
        $unite = $request->input('UNITE');
        if (!$user && $affaire->UNITE !== $unite) {
            return response(['error' => 'you dont have permission to update unite'], 401);
        }
        if (!$user && $key_sit->orderChr >= 4) {
            return response(['error' => 'you dont have permission to update situation'], 401);
        }

        $affaire->PTE_KNOWN = $request->input('PTE_KNOWN');
        $affaire->TIT_REQ = $request->input('TIT_REQ');
        $affaire->place = $request->input('place');
        $affaire->DATE_ENTRY = $request->input('DATE_ENTRY');
        $affaire->DATE_LAI = $request->input('DATE_LAI');
        $affaire->UNITE = $request->input('UNITE');
        $affaire->ARCHIVE = $request->input('ARCHIVE');
        $affaire->isValidate = $request->input('isValidate');
        $affaire->isPayed = $request->input('isPayed');
        $affaire->PRICE = $request->input('PRICE');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->aff_sit_id = $request->input('aff_sit_id');
        $affaire->Inter_id = $request->input('Inter_id');
        $affaire->client_id = $request->input('client_id');
        $affaire->resp_id = $request->input('resp_id');
        $affaire->nature_name = $request->input('nature_name');
        $affaire->update();
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
        $bus_mang->membership()->associate($affaire);
        $bus_mang->save();

        $mission = new Mission();
        $mission->title = "affaire" . $affaire->REF;
        $mission->description = "";
        $mission->startDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->endDate = date("Y-m-d H:i:s", strtotime(date($affaire->DATE_LAI)));
        $mission->allDay = 1;
        $mission->save();
        $subject = LogsEnumConst::Update . LogsEnumConst::Business . $affaire->REF;
        $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $affaire], 200);
    }

    public function destroy($id)
    {
        Affaire::destroy($id);

        return response(['data' => null], 204);
    }
}
