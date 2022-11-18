<?php

namespace App\Repository\Admin;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\Repository\Log\LogTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminResourceRepository implements IAdminResourceRepository{

    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::user()->organisation_id;
    }

    public function getUsers(){
    try {
       return  User::orderBy('name')->where('organisation_id','=',$this->organisation_id)->
        with(['roles' => function ($query) {
        $query->where('name', '<>', 'owner');
        }])->get();
    }catch (\Exception $exception){
        $this->Log($exception);
        return null;
    }
    }
    public function getRoles(){
    try {
        return Role::orderBy('name')->get();
    }catch (\Exception $exception){
        $this->Log($exception);
        return null;
    }
    }
    public function getRoutes(){
        try {
            return Route::orderBy('name')->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function getPermissions(){
        try {
            return Permission::orderBy('name')->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    private function getFess(GetFess $fess)
    {
        $arrayFess = DB::table('fees as af')->where('organisation_id','=',$this->organisation_id)->
        join('business_managements as w', 'w.id', '=', 'af.business_id');

        switch ($fess->get_table()) {
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
    public function getDefaultElementOfDashBoard($table,$from,$to,$orderBy){
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
        return [
            'fessArray' => $fessArray,
            'sites' => $sites,
            'byDateFolChoice' => $byDateFolChoice,
            'byDateAffChoice' => $byDateAffChoice,
        ];
    }
    public function logActivity($request){

    }
}
