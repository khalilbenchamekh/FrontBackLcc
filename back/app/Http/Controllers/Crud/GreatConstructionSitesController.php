<?php

namespace App\Http\Controllers\Crud;


use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\GreatConstructionSitesRequest;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Http\Resources\GetFess;
use App\Http\Resources\MemberShipType;
use App\Models\AllocatedBrigade;
use App\Models\BusinessManagement;
use App\Models\Fees;
use App\Models\GreatConstructionSites;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\File as Bus_File;


class GreatConstructionSitesController extends Controller
{

    public function __construct()
    {
        set_time_limit(8000000);
        $this->middleware('role:GreatConstructionSites_create|owner|admin', ['only' => ['store']]);
        $this->middleware('role:GreatConstructionSites_edit|owner|admin', ['only' => ['update']]);
        $this->middleware('role:GreatConstructionSites_read|owner|admin', ['only' => ['index']]);
        $this->middleware('role:GreatConstructionSites_delete|owner|admin', ['only' => ['destroy']]);
    }

    public function dashboard(Request $request)
    {

        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        if (!empty($from) || !empty($to)) {

            $validator = Validator::make($request->all(), [
                'from' => 'date_format:Y/m/d',
                'to' => 'date_format:Y/m/d',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }

        if (!empty($orderBy)) {
            $validator = Validator::make($request->all(), [
                'orderBy' => 'in:year,month',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $orderBy = 'year';
        }


        $byDateAffChoice = DB::table('g_c_s as g')
            ->join('locations as l', 'g.location_id', '=', 'l.id')
            ->join('users as u', 'g.resp_id', '=', 'u.id')
            ->whereBetween('g.date_of_receipt', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`g`.`date_of_receipt`) as `year`")
                    : DB::raw("MONTH(`g`.`date_of_receipt`) as `month`")
                ,
                DB::raw(" (SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='En cours'  ) as `En_cours`  "),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='Teminé') as `Teminé`"),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='En Attente de validation') as `En_Attente_de_validation`"),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='Annulé') as `Annulé`")
            )
            ->groupBy([$orderBy])
            ->get()
            ->reverse();
        $dataEn_cours = [];
        $dataTeminé = [];
        $dataEn_Attente_de_validation = [];
        $dataAnnulé = [];
        $gropBy = [];
        for ($i = 0; $i < sizeof($byDateAffChoice); $i++) {
            $item = $byDateAffChoice[$i];
            array_push($dataEn_cours, $item->En_cours);
            array_push($dataTeminé, $item->Teminé);
            array_push($dataEn_Attente_de_validation, $item->En_Attente_de_validation);
            array_push($dataAnnulé, $item->Annulé);
            array_push($gropBy, $item->$orderBy);
        }
        $series = [
            [
                "name" => "En cours",
                "data" => $dataEn_cours,
            ], [
                "name" => "Teminé",
                "data" => $dataTeminé,
            ], [
                "name" => "En Attente de validation",
                "data" => $dataEn_Attente_de_validation,
            ], [
                "name" => "Annulé",
                "data" => $dataAnnulé,
            ],

        ];
        $data = [
            "series" => $series,
            "categories" => array_unique($gropBy)
        ];
        return response(['data' => $data], 200);


    }


    public function index()
    {

        $data = DB::table('g_c_s as g')
            ->join('locations as l', 'g.location_id', '=', 'l.id')
            ->join('users as u', 'g.resp_id', '=', 'u.id')
            ->select(
                DB::raw('g.Market_title'),
                DB::raw('l.name as location_name'),
                DB::raw('u.name'),
                DB::raw('g.State_of_progress'),
                DB::raw('g.id'),
                DB::raw('g.*')
            )
            ->orderBy('g.id', 'DESC')
            ->get();

        return response(['data' => $data], 200);
    }

    public function store(GreatConstructionSitesRequest $request)
    {
        $allocated_brigades = $request->input('allocated_brigades');
        $price = $request->input('price');
        $location_id = $request->input('location_id');
        $Market_title = $request->input('Market_title');
        $resp_id = $request->input('resp_id');
        $advanced = $request->input('advanced');
        $observation = $request->input('observation');
        $Execution_phase = $request->input('Execution_phase');
        $State_of_progress = $request->input('State_of_progress');
        $DATE_LAI = $request->input('DATE_LAI');
        $date_of_receipt = $request->input('date_of_receipt');
        $arrayToReturend = explode(',', $allocated_brigades);
        $client_id = $request->input('client_id');
        $greatconstructionsites = new GreatConstructionSites();
        $greatconstructionsites->price = $price;
        $greatconstructionsites->location_id = $location_id;
        $greatconstructionsites->Market_title = $Market_title;
        $greatconstructionsites->client_id = $client_id;
        $greatconstructionsites->resp_id = $resp_id;
        $greatconstructionsites->DATE_LAI = $DATE_LAI;
        $greatconstructionsites->Execution_phase = $Execution_phase;
        $greatconstructionsites->State_of_progress = $State_of_progress;
        $greatconstructionsites->date_of_receipt = $date_of_receipt;
        $greatconstructionsites->Execution_report = "";
        $greatconstructionsites->Class_service = "";
        $greatconstructionsites->fees_decompte = $price - !empty($advanced) ? $advanced : 0;

        if (!empty($arrayToReturend)) {
            $tempFilesId = [];
            $filesArray = [
                'geoMapping',
                'geoMapping/GreatConstructionSites',
                'geoMapping/GreatConstructionSites/' . $Market_title,
            ];
            $allocated_b = collect();
            $toAssociete = [];
            foreach ($arrayToReturend as $field => $value) {
                $temp = AllocatedBrigade::updateOrCreate(["name" => $value]);
                $id = [
                    'a_b_id' => $temp->id
                ];
                array_push($toAssociete,
                    $id
                );
                $allocated_b->add($temp);
            }
            $bus_mang = new BusinessManagement();
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
            $greatconstructionsites->save();
            $bus_mang->membership()->associate($greatconstructionsites);
            $bus_mang->save();
            $greatconstructionsites->allocatedBrigades()->attach($toAssociete);
            if ($request->hasfile('Execution_report')) {
                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/Execution_report';
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }
                foreach ($request->file('Execution_report') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);

                }
                array_pop($filesArray);

            }
            if ($request->hasfile('Class_service')) {

                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/Class_service';
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }
                foreach ($request->file('Class_service') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);
                }
                array_pop($filesArray);
                array_pop($tempFilesId);
            }
            if ($request->hasfile('filenames')) {
                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/fees';
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
                    $fileModel = new Bus_File();
                    $fileModel->businessManagement()->associate(
                        $bus_mang->id
                    );
                    $fileModel->filename = $pathToMove . '/' . $name;
                    $fileModel->save();
                }

                $fessModel = new Fees();
                $fessModel->type = MemberShipType::greatConstructionSites;
                $fessModel->price = $price;
                $fessModel->advanced = $advanced;
                $fessModel->businessManagement()->associate(
                    $bus_mang->id

                );
                $fessModel->observation = $observation;
                $fessModel->save();
            }

        } else {
            return response(['error' => 'allocated_brigades cannot be empty'], 400);
        }
        $subject = LogsEnumConst::Add . LogsEnumConst::GSC . $greatconstructionsites->Market_title;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $greatconstructionsites], 201);
    }

    public function show($id)
    {
        $greatconstructionsites = GreatConstructionSites::findOrFail($id);

        return response(['data', $greatconstructionsites], 200);
    }

    public function update(GreatConstructionSitesRequest $request, $id)
    {
        $allocated_brigades = $request->input('allocated_brigades');
        $price = $request->input('price');
        $location_id = $request->input('location_id');
        $Market_title = $request->input('Market_title');
        $resp_id = $request->input('resp_id');
        $advanced = $request->input('advanced');
        $observation = $request->input('observation');
        $Execution_phase = $request->input('Execution_phase');
        $State_of_progress = $request->input('State_of_progress');
        $DATE_LAI = $request->input('DATE_LAI');
        $date_of_receipt = $request->input('date_of_receipt');
        $arrayToReturend = explode(',', $allocated_brigades);
        $greatconstructionsites = new GreatConstructionSites();
        $greatconstructionsites->price = $price;
        $greatconstructionsites->location_id = $location_id;
        $greatconstructionsites->Market_title = $Market_title;
        $greatconstructionsites->resp_id = $resp_id;
        $greatconstructionsites->DATE_LAI = $DATE_LAI;
        $greatconstructionsites->Execution_phase = $Execution_phase;
        $greatconstructionsites->State_of_progress = $State_of_progress;
        $greatconstructionsites->date_of_receipt = $date_of_receipt;
        $greatconstructionsites->Execution_report = "";
        $greatconstructionsites->Class_service = "";
        $greatconstructionsites->fees_decompte = $price - !empty($advanced) ? $advanced : 0;

        if (!empty($arrayToReturend)) {
            $tempFilesId = [];
            $filesArray = [
                'geoMapping',
                'geoMapping/GreatConstructionSites',
                'geoMapping/GreatConstructionSites/' . $Market_title,
            ];


            $allocated_b = collect();
            $toAssociete = [];
            foreach ($arrayToReturend as $field => $value) {
                $temp = AllocatedBrigade::updateOrCreate(["name" => $value]);
                $id = [
                    'a_b_id' => $temp->id
                ];
                array_push($toAssociete,
                    $id
                );
                $allocated_b->add($temp);
            }
            $bus_mang = new BusinessManagement();
            $greatconstructionsites->save();
            $bus_mang->membership()->associate($greatconstructionsites);
            $bus_mang->save();
            $greatconstructionsites->allocatedBrigades()->attach($toAssociete);
            if ($request->hasfile('Execution_report')) {
                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/Execution_report';
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }
                foreach ($request->file('Execution_report') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);

                }
                array_pop($filesArray);

            }
            if ($request->hasfile('Class_service')) {

                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/Class_service';
                array_push($filesArray, $pathToMove);
                foreach ($filesArray as $item) {
                    $path = public_path() . '/' . $item . '/';
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                }


                foreach ($request->file('Class_service') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = public_path() . '/' . $pathToMove;
                    $file->move($path, $name);
                }
                array_pop($filesArray);
                array_pop($tempFilesId);
            }
            if ($request->hasfile('filenames')) {


                $pathToMove = 'geoMapping/GreatConstructionSites/' . $Market_title . '/fees';
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
                    $fileModel = new Bus_File();
                    $fileModel->businessManagement()->associate(
                        $bus_mang->id
                    );
                    $fileModel->filename = $pathToMove . '/' . $name;
                    $fileModel->save();
                }

                $fessModel = new Fees();
                $fessModel->type = MemberShipType::greatConstructionSites;
                $fessModel->price = $price;
                $fessModel->advanced = $advanced;
                $fessModel->businessManagement()->associate(
                    $bus_mang->id

                );
                $fessModel->observation = $observation;
                $fessModel->save();
            }

        } else {
            return response(['error' => 'allocated_brigades cannot be empty'], 400);
        }
        $subject = LogsEnumConst::Update . LogsEnumConst::GSC . $greatconstructionsites->Market_title;
   $logs = new LogActivity();
        $logs->addToLog($subject, $request);
        return response(['data' => $greatconstructionsites], 200);
    }

    public function destroy($id)
    {
        GreatConstructionSites::destroy($id);

        return response(['data' => null], 204);
    }
}
