<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminDashBoardRequest;
use App\Http\Requests\Enums\AbrvDate;
use App\Http\Requests\Enums\RangeDateChoice;

use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Models\Affaire;
use App\Models\AffaireNature;
use App\Models\AffaireSituation;
use App\Models\business;
use App\Models\BusinessManagement;
use App\Models\Client;
use App\Models\FolderTech;
use App\Models\FolderTechNature;
use App\Models\FolderTechSituation;
use App\Models\GreatConstructionSites;
use App\Models\Intermediate;
use App\Models\LoadTypes;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Events\CountDown as CountDownEvent;

class ResourceController extends Controller
{

    public function getCountDown()
    {

        $from = Carbon::now()->toDateString();
        $to = date("Y-m-d", strtotime(Carbon::now() . "+15 days"));

        $great = GreatConstructionSites::whereBetween('DATE_LAI', [$from, $to])
            ->select('Market_title')
            ->get();

        $affaire = Affaire::whereBetween('DATE_LAI', [$from, $to])
            ->select('REF')
            ->get();

        $folderTech = FolderTech::whereBetween('DATE_LAI', [$from, $to])
            ->select('REF')
            ->get();
        $arrayNotification = [];
        if (count($great) !== 0) {
            $temp = [];
            foreach ($great as $item) {
                array_push($temp, [
                    'description' => "Le Grand Chantier sous référence" . $item->Market_title . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);

        }
        if (count($affaire) !== 0) {

            $temp = [];
            foreach ($affaire as $item) {
                array_push($temp, [
                    'description' => "L'affaire sous référence" . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }
        if (count($folderTech) !== 0) {
            $temp = [];
            foreach ($folderTech as $item) {
                array_push($temp, [
                    'description' => " Le dossier technique sous référence " . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }

        if (!empty($arrayNotification)) {
            $notifications = $arrayNotification[0];
            if (!empty($notifications)) {
                $not = new Notification();
                $not->newQuery()->insert($notifications);
                broadcast(new CountDownEvent($notifications));
            }
        }
        return response($arrayNotification[0], 200);
    }

    public function getIntermediate()
    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $inter = Intermediate::where('name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('second_name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('Function', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('tel', 'like', '%' . $request->input('key') . '%')
//            ->get([
//                DB::raw('name as value'),
//                DB::raw(' id'),
//            ]);
//        return response()->json($inter);
        $inter = Intermediate::latest()->get();
        return response(['data' => $inter], 200);
    }

    public function getClient()
    {
        $bus = Client::latest()->get();
        return response(['data' => $bus], 200);
    }

    public function getBusinessSituation()
    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $inter = AffaireSituation::where('Name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('orderChr', 'like', '%' . $request->input('key') . '%')
//            ->get([
//                DB::raw('Name as value'),
//                DB::raw('id'),
//
//            ]);
//        return response()->json($inter);
        $bus = AffaireSituation::latest()
            ->select()
            ->get();
        return response(['data' => $bus], 200);
    }

//    public function getClientAutocomplete(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $client =
//            DB::table('clients as cl')
//                ->join('businesses as bu', function ($join) {
//                    $join->on('bu.id', '=', 'cl.membership_id')->where('cl.membership_type', '=', 'App\Models\business');
//                })
//                ->where('cl.name', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('bu.ICE', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('bu.RC', 'like', '%' . $request->input('key') . '%')
//                ->get([
//                    DB::raw('cl.name as value'),
//                    DB::raw('cl.id'),
//
//                ]);
//        return response()->json($client);
//
//    }

//    public function geResp(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $client =
//            DB::table('employees as emp')
//                ->join('users as uti', function ($join) {
//                    $join->on('emp.id', '=', 'uti.membership_id')->where('uti.membership_type', '=', 'App\Models\Employee');
//                })
//                ->where('emp.personal_number', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('emp.profession_number', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.name', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.username', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.email', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.firstname', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.middlename', 'like', '%' . $request->input('key') . '%')
//                ->orWhere('uti.lastname', 'like', '%' . $request->input('key') . '%')
//                ->get([
//                    DB::raw('uti.name as value'),
//                    DB::raw('uti.id'),
//                ]);
//        return response()->json($client);
//
//    }

    public function geFolderTechSituation()
    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $inter = FolderTechSituation::where('Name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('orderChr', 'like', '%' . $request->input('key') . '%')
//            ->get([
//                DB::raw('Name as value'),
//                DB::raw('id'),
//
//            ]);
        $bus = FolderTechSituation::latest()->get();
        return response(['data' => $bus], 200);
    }

    public function getNatureBusinessName()
    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $inter = AffaireNature::where('Name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('Abr_v', 'like', '%' . $request->input('key') . '%')
//            ->get([
//                DB::raw('Name as value'),
//                DB::raw('id'),
//            ]);
//        return response()->json($inter);
        $bus = AffaireNature::latest()->get();
        return response(['data' => $bus], 200);
    }

    public function getFolderTechName()
    {
//        $validator = Validator::make($request->all(), [
//            'key' => 'required|string|max:255',
//        ]);
//        if ($validator->fails()) {
//            return response($validator->errors(), 400);
//        }
//        $inter = FolderTechNature::where('Name', 'like', '%' . $request->input('key') . '%')
//            ->orWhere('Abr_v', 'like', '%' . $request->input('key') . '%')
//            ->get([
//                DB::raw('Name as value'),
//                DB::raw('id'),
//            ]);
//        return response()->json($inter);
        $bus = FolderTechNature::latest()->get();
        return response(['data' => $bus], 200);
    }

    public function getLocations()
    {
//        $locations =BusinessManagement::where([['longitude','!=',null],['latitude','=', null]])->select(
        $locations = BusinessManagement::
        where('longitude', '!=', 'null')
            ->where(function ($query) {
                $query->where('latitude', '!=', 'null');
            })
            ->select(
                DB::raw("membership_type"),
                DB::raw("COUNT(membership_type) as count_type"),
                'longitude',
                'latitude'
            )
            ->groupBy(["membership_type"])
            ->groupBy(["longitude", "latitude"])
            ->get();
        return response(['data' => $locations], 200);

    }

    public function getLoadType()
    {
        $locations = LoadTypes::latest()->get();
        return response(['data' => $locations], 200);
    }

    public function getUser()
    {
        $users = User::latest()
            ->select('name', 'id', 'username')
            ->get();
        return response(['data' => $users], 200);
    }

    public function getLocationsAutoComplete()
    {
        $locations = Cache::rememberForever('location', function () {
            return DB::table('locations')->get();
        });
        return response(['data' => $locations], 200);
    }

    public function getAllocatedBrigades()
    {
        $allocated_brigades = DB::table('allocated_brigades')->get();
        return response(['data' => $allocated_brigades], 200);
    }

    public function getSearch(Request $request)
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
        $table = $request->input('table');
        if (!empty($table)) {

            $validator = Validator::make($request->all(), [
                'table' => 'in:affaires,folderteches,sites,loads',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $table = TableChoice::Great;
        }
        $fess = new GetFess();
        $fess->set_from($from);
        $fess->set_to($to);
        $fess->set_orderBy($orderBy);
        $fess->set_table($table == TableChoice::Sites ? TableChoice::Great : $table);
        $fessArray = $this->getFess($fess);
        return response(['data' => $fessArray], 200);
    }

    public function getSearchWithDetails(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $id = $request->input('id');
        $table = $request->input('table');
        if (!empty($table)) {

            $validator = Validator::make($request->all(), [
                'table' => 'in:affaires,folderTech,sites,loads',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
        } else {
            $table = TableChoice::Great;
        }
        $fess = new GetFess();
        $fess->set_table($table == TableChoice::Sites ? TableChoice::Great : $table);
        $fessArray = $this->getDetails($fess, $id);
        return response(['data' => $fessArray], 200);
    }

    private function getFess(GetFess $fess)
    {
        $table = $fess->get_table();
        $arrayFess = DB::table($table . ' as af');
        switch ($fess->get_table()) {
            case TableChoice::Load:
                $arrayFess = $arrayFess
                    ->select(DB::raw('af.*'));
                break;
            case TableChoice::Business:
                $arrayFess = $arrayFess->join('affairesituations as w', 'af.aff_sit_id', '=', 'w.id')
                    ->select(DB::raw('af.*'));
                break;
            case TableChoice::FolderTech:
                $arrayFess = $arrayFess->join('foldertechsituations as w', 'af.folder_sit_id', '=', 'w.id')
                    ->select(DB::raw('w.*'));
                break;
            case TableChoice::Great:
                $arrayFess = $arrayFess->join('locations as l', 'af.location_id', '=', 'l.id')
                    ->join('users as u', 'af.resp_id', '=', 'u.id')
                    ->select(
                        DB::raw('af.Market_title'),
                        DB::raw('l.name as location_name'),
                        DB::raw('u.name'),
                        DB::raw('af.State_of_progress'),
                        DB::raw('af.id')
                    );
                break;
            default :
                return $arrayFess;
        }
        $arrayFess = $arrayFess->whereBetween('af.created_at', [$fess->get_from(), $fess->get_to()])
            ->get()
            ->reverse();
        return $arrayFess;
    }

    private function getDetails(GetFess $fess, $id)
    {
        $arrayFess = DB::table('fees as af')->join('business_managements as w', 'w.id', '=', 'af.business_id')
            ->where('w.membership_id', '=', $id);

        switch ($fess->get_table()) {
            case TableChoice::Business:
                $arrayFess
                    ->where('w.membership_type', 'like', '%' . "Affaire");
                break;
            case TableChoice::FolderTech:
                $arrayFess
                    ->where('w.membership_type', 'like', '%' . "FolderTech");
                break;
            case TableChoice::Great:
                $arrayFess
                    ->where('w.membership_type', 'like', '%' . "GreatConstructionSites");
                break;

            default :
                return $arrayFess;
        }
        $arrayFess = $arrayFess
            ->select(
                DB::raw("af.*")
            )
            ->get()
            ->reverse();
        return $arrayFess;
    }

    public function getNotifications(Request $request, $page = 1)
    {
        $notifications = DB::table('notifications')->latest()->paginate( 15, ['*'],$page);
        return response(['data' => $notifications], 200);
    }

}
