<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 06/06/2020
 * Time: 14:14
 */

namespace App\Http\Controllers\Statistiques;


use App\Http\Controllers\Controller;
use App\Http\Requests\Enums\ReportChoice;
use App\Http\Requests\Enums\StatistiquesChoices;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Requests\Statistiques\StatistiqueRequest;
use App\Http\Resources\GetFess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StatistiquesController extends Controller
{
    public function index(Request $request)
    {
        $ongoingProject = $this->ongoingProject($request);
        return response()->json(["data" => $ongoingProject], 200);
    }

    private function FinancialReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->getFessReport($fess, $value, $table, $type);
    }

    private function FinancialReportTva(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->getFessReportTVA($fess, $value, $table, $type);
    }

    private function TurnoverReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->getFessReportCA($fess, $value, $table, $type);
    }

    private function geetFessbusinessManagements(GetFess $fess, $report = null, $value = null, $type = null)
    {
        $tables = new TableChoice();
        $tempArray = $tables->getConstants();
        $arrayToReturn = [];
        foreach ($tempArray as $item) {
            if ($item != TableChoice::All && $item != TableChoice::Sites && $item != TableChoice::Load) {
                $report == null ?
                    array_push($arrayToReturn, $this->feesToArray([
                        "$item" =>
                            $this->getFess($fess, $item)
                    ], $item))
                    : array_push($arrayToReturn, [
                    "$item" =>
                        $this->generateReport($fess, $value, $item, $report, $type)
                ]);
            }
        }
        return $arrayToReturn;
    }

    private function generateReport(GetFess $fess, $value, String $table = null, $report = null, $type = null)
    {
        $data = [];
        switch ($report) {
            case ReportChoice::FinancialReport:
                array_push($data, $this->FinancialReport($fess, $value, $table, $type));
                break;
            case ReportChoice::TvaReport:

                array_push($data, $this->FinancialReportTva($fess, $value, $table, $type));
                break;
            case ReportChoice::TurnoverReport:
                array_push($data, $this->TurnoverReport($fess, $value, $table, $type));
                break;
            default :
                return $data;
        };
        return $data;
    }

    private function getFess(GetFess $fess, String $table = null)
    {
        if ($table != null) {
            $arrayFess = DB::table('fees as fe')
                ->join('business_managements as b', 'b.id', '=', 'fe.business_id')
                ->join($table . ' as af', 'af.id', '=', 'b.membership_id');

            switch ($table) {
                case TableChoice::Business:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "Affaire");
                    break;
                case TableChoice::FolderTech:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "FolderTech");
                    break;
                case TableChoice::Great:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "GreatConstructionSites");
                    break;
                default :
                    return $arrayFess;
            };

            $arrayFess = $arrayFess
                ->whereBetween('fe.created_at', [$fess->get_from(), $fess->get_to()])
                ->select(
                    "af.*",
                    "b.DATE_LAI",
                    "fe.*"
                )
                ->get()
                ->reverse();

            return $arrayFess;
        } else {
            return [];
        }

    }

    private function getFessReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        if ($table != null) {
            $arrayFess = DB::table('fees as fe')
                ->join('business_managements as b', 'b.id', '=', 'fe.business_id')
                ->join($table . ' as af', 'af.id', '=', 'b.membership_id');

            switch ($table) {
                case TableChoice::Business:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "Affaire");
                    break;
                case TableChoice::FolderTech:

                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "FolderTech");
                    break;
                case TableChoice::Great:

                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "GreatConstructionSites");
                    break;
                default :
                    return $arrayFess;
            };;
            switch ($type) {
                case StatistiquesChoices::Employee:
                    $arrayFess->where("resp_id", "=", $value);
                    break;
                case StatistiquesChoices::Client:
                    $arrayFess->where("client_id", "=", $value);
                    break;
                default :
                    return $arrayFess;
            }
            $arrayFess = $arrayFess
                ->whereBetween('fe.created_at', [$fess->get_from(), $fess->get_to()])
                ->select(
                    TableChoice::Great != $table ?
                        "af.REF" : "af.id",
                    "af.client_id",
                    "b.DATE_LAI",
                    DB::raw("SUM(`fe`.`advanced`) as `FinancialReport`")
                )
                ->orderBy("FinancialReport")
                ->groupBy([TableChoice::Great != $table ?
                    "af.REF" : "af.id",
                    "af.client_id",
                    "b.DATE_LAI"])
                ->get()
                ->reverse();

            return $arrayFess;
        } else {
            return [];
        }

    }

    private function getFessReportTVA(GetFess $fess, $value, String $table = null, $type = null)
    {
        if ($table != null) {
            $arrayFess = DB::table('fees as fe')
                ->join('business_managements as b', 'b.id', '=', 'fe.business_id')
                ->join($table . ' as af', 'af.id', '=', 'b.membership_id')
                ->
                select(

                    TableChoice::Great != $table ?
                        "af.REF" : "af.id",
                    "af.client_id",
                    "fe.price",
                    "b.DATE_LAI",
                    DB::raw("SUM(`fe`.`advanced`) as `FinancialReport`")
                );
            switch ($table) {
                case TableChoice::Business:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "Affaire");
                    break;
                case TableChoice::FolderTech:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "FolderTech");
                    break;
                case TableChoice::Great:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "GreatConstructionSites");
                    break;
                default :
                    return $arrayFess;
            };
            switch ($type) {
                case StatistiquesChoices::Employee:
                    $arrayFess->where("resp_id", "=", $value);
                    break;
                case StatistiquesChoices::Client:
                    $arrayFess->where("client_id", "=", $value);
                    break;
                default :
                    return $arrayFess;
            }
            $arrayFess = $arrayFess
                ->where("b.ttc", "=", '1')
                ->whereBetween('fe.created_at', [$fess->get_from(), $fess->get_to()])
                ->orderBy("FinancialReport")
                ->groupBy([TableChoice::Great != $table ?
                    "af.REF" : "af.id",
                    "fe.price",

                    "af.client_id",
                    "b.DATE_LAI"])
                ->get()
                ->reverse();
            return $this->ispayed($arrayFess);
        } else {
            return [];
        }

    }

    private function ispayed($arra = [])
    {
        $temp = [];
        for ($i = 0; $i < sizeof($arra); $i++) {
            $item = $arra[$i];
            if (isset($item->price) || !empty($item->price) && isset($item->FinancialReport) || !empty($item->FinancialReport)) {
                if ($item->price <= $item->FinancialReport) {
                    array_push(
                        $temp, $item);
                }
            } else {
                $i = sizeof($arra);
            }
        }
        return $temp;
    }

    private function getFessReportCA(GetFess $fess, $value, String $table = null, $type = null)
    {
        if ($table != null) {
            $arrayFess = DB::table('fees as fe')
                ->join('business_managements as b', 'b.id', '=', 'fe.business_id')
                ->join($table . ' as af', 'af.id', '=', 'b.membership_id')
                ->
                select(
                    TableChoice::Great != $table ?
                        "af.REF" : "af.id",
                    "af.client_id",
                    "fe.price",
                    "b.DATE_LAI",
                    DB::raw("SUM(`fe`.`advanced`) as `FinancialReport`")
                );
            switch ($table) {
                case TableChoice::Business:
                    $arrayFess
                        ->join('affairesituations as w', 'w.id', '=', 'af.aff_sit_id')
                        ->where('w.Name', '=', 'PRÊT POUR LIVRAISON')
                        ->orWhere('w.Name', '=', 'PRÊT POUR LIVRAISON')
                        ->orWhere('w.orderChr', '=', '4')
                        ->orWhere('w.orderChr', '=', '5')
                        ->where('b.membership_type', "LIKE", '%' . "Affaire");
                    break;
                case TableChoice::FolderTech:
                    $arrayFess
                        ->join('foldertechsituations as w', 'w.id', '=', 'af.folder_sit_id')
                        ->where('w.Name', '=', 'DT. RECIPISSEE OBTENU')
                        ->orWhere('w.Name', '=', 'DT. RECIPISSE LIVREE')
                        ->orWhere('w.orderChr', '=', '5')
                        ->orWhere('w.orderChr', '=', '6')
                        ->where('b.membership_type', "LIKE", '%' . "FolderTech");
                    break;
                case TableChoice::Great:
                    $arrayFess
                        ->where('b.membership_type', "LIKE", '%' . "GreatConstructionSites");
                    break;
                default :
                    return $arrayFess;
            };
            switch ($type) {
                case StatistiquesChoices::Employee:
                    $arrayFess->where("resp_id", "=", $value);
                    break;
                case StatistiquesChoices::Client:
                    $arrayFess->where("client_id", "=", $value);
                    break;
                default :
                    return $arrayFess;
            }
            $arrayFess = $arrayFess
                ->where("b.ttc", "=", '1')
                ->whereBetween('fe.created_at', [$fess->get_from(), $fess->get_to()])
                ->groupBy([TableChoice::Great != $table ?
                    "af.REF" : "af.id",
                    "af.client_id",
                    "fe.price",
                    "b.DATE_LAI"])
                ->get()
                ->reverse();

            return $arrayFess;
        } else {
            return [];
        }
    }

    private function DateLaiv($data = [], $gropBy = [], $inProgress = [],
                              $notInProgress = [], String $name = TableChoice::Business)
    {
        $to = Carbon::now()->toDateString();

        for ($i = 0; $i < sizeof($data); $i++) {
            $item = $data[$i];
            if (isset($item->DATE_LAI) || !empty($item->DATE_LAI)) {
                $time = strtotime($item->DATE_LAI);
                $newformat = date('Y-m-d', $time);
                $newformat < $to ? array_push(

                    $inProgress, $item) : array_push($notInProgress, $item);


            } else {
                $i = sizeof($data);
            }
        }

        $arrayToReturn = [
            $name => [
                "notInProgress" => $notInProgress,
                "gropBy" => $gropBy,
                "inProgress" => $inProgress,
            ]

        ];
        return $arrayToReturn;
    }

    private function feesToArray($array = [], $currentItem = null)
    {
        $to = Carbon::now()->toDateString();

        $pa = [];
        $imp = [];
        $pEnd = [];
        for ($i = 0; $i < sizeof($array); $i++) {
            $item = $array[$currentItem];
            if (sizeof($item) > 0) {
                $item = $item[$i];
                $time = strtotime($item->DATE_LAI);
                $newformat = date('Y-m-d', $time);
                if (isset($item->DATE_LAI) || !empty($item->DATE_LAI) ||
                    isset($item->price) || !empty($item->price)
                    || isset($item->advanced) || !empty($item->advanced)) {
                    if ($item->price <= $item->advanced) {
                        $newformat >= $to ? array_push(

                            $pEnd, $item) : array_push($pa, $item);
                    } else {

                        array_push($imp, $item);

                    }


                } else {
                    $i = sizeof($array);
                }
            }


        }
        $arrayToReturn = [
            $currentItem => [
                "factures_impayées" => $imp,
                "factures_payées" => $pa,
                "projet_non_livré" => $pEnd,
            ]

        ];
        return $arrayToReturn;

    }

    private function MakeQueries($from, $to, $orderBy, $value, $type = null)
    {

        $byDateAffChoice = DB::table('affairesituations as af')
            ->join('affaires as w', 'af.id', '=', 'w.aff_sit_id');
        $sites = DB::table('g_c_s as w');
        $byDateFolChoice = DB::table('foldertechsituations as af')
            ->join('folderteches as w', 'af.id', '=', 'w.folder_sit_id');
        if ($value != null) {
            switch ($type) {
                case StatistiquesChoices::Employee:
                    $byDateAffChoice->where("resp_id", "=", $value);
                    $sites->where("resp_id", "=", $value);
                    $byDateFolChoice->where("resp_id", "=", $value);
                    break;
                case StatistiquesChoices::Client:
                    $byDateAffChoice->where("client_id", "=", $value);
                    $sites->where("client_id", "=", $value);
                    $byDateFolChoice->where("client_id", "=", $value);
                    break;
                default :
                    return null;
            };
        }


        $byDateAffChoice = $byDateAffChoice->
        whereBetween('w.DATE_ENTRY', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                    : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`"),
                "w.*"
            )
            ->get()
            ->reverse();

        $sites = $sites->
        whereBetween('w.date_of_receipt', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`w`.`date_of_receipt`) as `year`")
                    : DB::raw("MONTH(`w`.`date_of_receipt`) as `month`"),
                "w.*"

            )
            ->get()
            ->reverse();


        $byDateFolChoice = $byDateFolChoice
            ->whereBetween('w.DATE_ENTRY', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`w`.`DATE_ENTRY`) as `year`")
                    : DB::raw("MONTH(`w`.`DATE_ENTRY`) as `month`"),
                "w.*"

            )
            ->get()
            ->reverse();

        $arrayToReturn = [
            "byDateAffChoice" => $byDateAffChoice,
            "byDateFolChoice" => $byDateFolChoice,
            "sites" => $sites,
        ];

        return $arrayToReturn;
    }

    private function ongoingProject(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        $table = TableChoice::All;
        $type = $request->input('type');
        $rapport = $request->input('rapport');
        $value = null;
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
        if (!empty($type)) {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:global,client,employee',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
            if ($type != StatistiquesChoices::Global) {
                if ($type == StatistiquesChoices::Employee) {
                    $validator = Validator::make($request->all(), [
                        'resp_id' => 'exists:users,id',
                    ]);
                    if ($validator->fails()) {
                        return response($validator->errors(), 400);
                    }
                    $value = $request->input('resp_id');
                } else {
                    $validator = Validator::make($request->all(), [
                        'client_id' => 'exists:clients,id',
                    ]);
                    if ($validator->fails()) {
                        return response($validator->errors(), 400);
                    }
                    $value = $request->input('client_id');
                }
            }
        } else {
            $type = StatistiquesChoices::Global;
        }
        $fess = new GetFess();
        $fess->set_from($from);
        $fess->set_to($to);
        $fess->set_orderBy($orderBy);
        $fess->set_table($table);
        if (!empty($rapport)) {

            $validator = Validator::make($request->all(), [
                'rapport' => 'in:financier,tva,ca',
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }

            return $this->geetFessbusinessManagements($fess, $rapport, $value, $type);
        } else {
            $tempQuerie = $this->MakeQueries($from, $to, $orderBy, $value, $type);
            $byDateAffChoice = $tempQuerie['byDateAffChoice'];
            $sites = $tempQuerie['sites'];
            $byDateFolChoice = $tempQuerie['byDateFolChoice'];
            $fessArray = $this->geetFessbusinessManagements($fess);
            $dataEn_cours = [];
            $dataTeminé = [];
            $gropBy = [];
            $tempData = [];
            $temp = $this->DateLaiv($byDateAffChoice, $gropBy, $dataEn_cours, $dataTeminé, TableChoice::Business);
            $tempArr = $temp[TableChoice::Business];
            array_push($tempData, $temp);
            $dataEn_cours = $tempArr['inProgress'];
            $dataTeminé = $tempArr['notInProgress'];
            $gropBy = $tempArr['gropBy'];
            $temp = $this->DateLaiv($sites, $gropBy, $dataEn_cours, $dataTeminé, TableChoice::Sites);
            $tempArr = $temp[TableChoice::Sites];
            $dataEn_cours = $tempArr['inProgress'];
            $dataTeminé = $tempArr['notInProgress'];
            $gropBy = $tempArr['gropBy'];
            array_push($tempData, $temp);
            $temp = $this->DateLaiv($byDateFolChoice, $gropBy, $dataEn_cours, $dataTeminé, TableChoice::FolderTech);
            $tempArr = $temp[TableChoice::FolderTech];
            $gropBy = $tempArr['gropBy'];
            array_push($tempData, $temp);
            $series = [
                [
                    "no-fees" => $tempData,
                ], [
                    "fees" => $fessArray,
                ]
            ];
            $data = [
                "series" => $series,
                "categories" => array_unique($gropBy)
            ];

            return $data;
        }

    }
}
