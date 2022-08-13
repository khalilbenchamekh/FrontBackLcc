<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use App\Http\Requests\Auth\PaginatinRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:owner', ['except' => ['getUsers']]);
    }

    public function setUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permission' => 'required|string|min:4|max:255',
            'user' => 'required|integer',
            'attach_or_detach' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $permission = $request->input('permission');
        $attach_or_detach = $request->input('attach_or_detach');
        $id = $request->input('user');
        $user = User::find($id);
        $role = Role::where('name', 'like', $permission)->get();
        if (!empty($role)) {
            if (isset($role[0]->id)) {
                $attach_or_detach == true ?
                    $user->attachRole($role[0]->id) :
                    $user->detachRole($role[0]->id);
            }
        }
        return response()->json(['data' => $user], 200);
    }

    public function getUsers(Request $request)
    {
        $permission = Permission::where('name', 'like', '%' . $request->input('route_name') . '%')->get();
        $usersArray = [];

        if (!empty($permission)) {
            $users = User::orderBy('name')->get();
            for ($i = 0; $i < sizeof($users); $i++) {
                $user = $users[$i];
                if (!$user->hasRole('owner')) {
                    $user = $users[$i];

                    $tempUser = [
                        'user' => $user->firstname . ' ' . $user->lastname,
                        'id' => $user->id,
                        'create' => $user->can([$request->input('route_name') . '_' . 'create']),
                        'edit' => $user->can([$request->input('route_name') . '_' . 'edit']),
                        'delete' => $user->can([$request->input('route_name') . '_' . 'delete']),
                        'read' => $user->can([$request->input('route_name') . '_' . 'read']),

                    ];
                    array_push($usersArray, $tempUser);
                }


            }
        }

        return response()->json($usersArray);
    }

    public function getRoles(Request $request)
    {
        $roles = Role::orderBy('name')->get();
        return response()->json($roles);
    }

    public function getRoutes(Request $request)
    {
        $roles = Route::orderBy('name')->get();
        return response()->json($roles);
    }

    public function getPermissions(Request $request)
    {
        $permissions = Permission::orderBy('name')->get();
        return response()->json($permissions);
    }

    private function getFess(GetFess $fess)
    {
        $arrayFess = DB::table('fees as af')->join('business_managements as w', 'w.id', '=', 'af.business_id');

        switch ($fess->get_table()) {
            case TableChoice::All:
                $arrayFess = $arrayFess;
                break;
            case TableChoice::Business:
                $arrayFess
                    ->where('w.membership_type', "LIKE", "App\Models\Affaire");
                break;
            case TableChoice::FolderTech:
                $arrayFess
                    ->where('w.membership_type', "LIKE", "App\Models\FolderTech");
                break;
            case TableChoice::Sites:
                $arrayFess
                    ->where('w.membership_type', "LIKE", "App\Models\GreatConstructionSites");
                break;
            default :
              return  $arrayFess;
        }
        $arrayFess = $arrayFess->whereBetween('af.created_at', [$fess->get_from(), $fess->get_to()])
            ->select(
                $fess->get_orderBy() === 'year' ?
                    DB::raw("YEAR(`w`.`created_at`) as `year`")
                    : DB::raw("MONTH(`w`.`created_at`) as `month`")
                ,
                DB::raw(" (SELECT count(`af`.`id`) FROM `fees` as `af`  where `af`.`price` > `af`.`advanced`) as `factures_impayées`"),
                DB::raw(" (SELECT count(`af`.`id`) FROM `fees` as `af`  where `af`.`price` <= `af`.`advanced`) as `factures_payées`")
            )
            ->groupBy([$fess->get_orderBy()])
            ->get()
            ->reverse();
        return $arrayFess;
    }

    private function ongoingProject(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        $table = $request->input('table');
        if (!empty($table)) {

            $validator = Validator::make($request->all(), [
                'table' => 'in:affaires,folderteches,sites,all',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $table = TableChoice::All;
        }
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
        $byDateAffChoice = [];
        $byDateFolChoice = [];
        $sites = [];
        switch ($table) {
            case TableChoice::All:
                $byDateAffChoice = DB::table('affairesituations as af')
                    ->join('affaires as w', 'af.id', '=', 'w.aff_sit_id')
                    ->whereBetween('w.DATE_ENTRY', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                            : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `affaires` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `affaires` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();
                $sites = DB::table('g_c_s as w')
                    ->whereBetween('w.date_of_receipt', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`date_of_receipt`) as `year`")
                            : DB::raw("MONTH(`w`.`date_of_receipt`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `g_c_s` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `g_c_s` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();


                $byDateFolChoice = DB::table('foldertechsituations as af')
                    ->join('folderteches as w', 'af.id', '=', 'w.folder_sit_id')
                    ->whereBetween('w.DATE_ENTRY', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                            : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `folderteches` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `folderteches` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();
                break;
            case TableChoice::Business:
                $byDateAffChoice = DB::table('affairesituations as af')
                    ->join('affaires as w', 'af.id', '=', 'w.aff_sit_id')
                    ->whereBetween('w.DATE_ENTRY', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                            : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `affaires` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `affaires` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();
                break;
            case TableChoice::FolderTech:
                $byDateFolChoice = DB::table('foldertechsituations as af')
                    ->join('folderteches as w', 'af.id', '=', 'w.folder_sit_id')
                    ->whereBetween('w.DATE_ENTRY', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                            : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `folderteches` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `folderteches` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();
                break;
            case TableChoice::Sites:
                $sites = DB::table('g_c_s as w')
                    ->whereBetween('w.date_of_receipt', [$from, $to])
                    ->select(
                        $orderBy === 'year' ?
                            DB::raw("YEAR(`w`.`date_of_receipt`) as `year`")
                            : DB::raw("MONTH(`w`.`date_of_receipt`) as `month`")
                        ,
                        DB::raw(" (SELECT count(`w`.`id`) FROM `g_c_s` as `w`  where date(`w`.`DATE_LAI`) >= CURDATE()) as `projets_en_cours`"),
                        DB::raw(" (SELECT count(`w`.`id`) FROM `g_c_s` as `w` where date(`w`.`DATE_LAI`) <= CURDATE()) as `projets_terminés`")
                    )
                    ->groupBy([$orderBy])
                    ->get()
                    ->reverse();
                break;
            default:
                echo "";
        }


        $fess = new GetFess();
        $fess->set_from($from);
        $fess->set_to($to);
        $fess->set_orderBy($orderBy);
        $fess->set_table($table);
        $fessArray = $this->getFess($fess);
        $dataEn_cours = [];
        $factures_impayées = [];
        $factures_payées = [];
        $dataTeminé = [];
        $gropBy = [];
        for ($i = 0; $i < sizeof($fessArray); $i++) {
            $item = $fessArray[$i];
            array_push($factures_impayées, $item->factures_impayées);
            array_push($factures_payées, $item->factures_payées);
            array_push($gropBy, $item->$orderBy);
        }
        for ($i = 0; $i < sizeof($byDateAffChoice); $i++) {
            $item = $byDateAffChoice[$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }
        for ($i = 0; $i < sizeof($sites); $i++) {
            $item = $sites[$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }

        for ($i = 0; $i < sizeof($byDateFolChoice); $i++) {
            $item = $byDateFolChoice[$i];
            array_push($dataEn_cours, $item->projets_en_cours);
            array_push($dataTeminé, $item->projets_terminés);
            array_push($gropBy, $item->$orderBy);
        }
        $series = [
            [
                "name" => "projets encours",
                "data" => $dataEn_cours,
            ], [
                "name" => "projets terminés",
                "data" => $dataTeminé,
            ], [
                "name" => "factures impayées",
                "data" => $factures_impayées,
            ], [
                "name" => "factures_payées",
                "data" => $factures_payées,
            ],

        ];
        $data = [
            "series" => $series,
            "categories" => array_unique($gropBy)
        ];

        return $data;
    }

    public function getDefaultElementOfDashBoard(Request $request)
    {
        $ongoingProject = $this->ongoingProject($request);
        return response()->json(["data" => $ongoingProject], 200);
    }

    public function logActivity(PaginatinRequest $request)
    {
        $log = new LogActivity();
        $logs = $log->logActivityLists($request);
        return response()->json($logs);
    }
}
