<?php


namespace App\Repository\Statistique;

use App\Http\Requests\Enums\StatistiquesChoices;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatistiqueRepository implements IStatistiqueRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function MakeQueries($from, $to, $orderBy, $value, $type = null)
    {
        try {
            $byDateAffChoice = DB::table('affairesituations as af')
            ->where("organisation_id","=",$this->organisation_id)
            ->join('affaires as w', 'af.id', '=', 'w.aff_sit_id');
        $sites = DB::table('g_c_s as w')->where("organisation_id","=",$this->organisation_id);
        $byDateFolChoice = DB::table('foldertechsituations as af')
            ->where("organisation_id","=",$this->organisation_id)
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
    } catch (\Exception $exception) {
        $this->Log($exception);
        return null;
    }
    }

    public function getFess(GetFess $fess, String $table = null)
    {
        try {
            if ($table != null) {
                $arrayFess = DB::table('fees as fe')
                    ->where("organisation_id","=",$this->organisation_id)
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
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function getFessReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        try {
            if ($table != null) {
                $arrayFess = DB::table('fees as fe')
                    ->where("organisation_id","=",$this->organisation_id)
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
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function getFessReportTVA(GetFess $fess, $value, String $table = null, $type = null)
    {
        try {
            if ($table != null) {
                $arrayFess = DB::table('fees as fe')
                    ->where("organisation_id","=",$this->organisation_id)
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
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    private function ispayed($arra = [])
    {
        try {
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
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function getFessReportCA(GetFess $fess, $value, String $table = null, $type = null)
    {
        try {
            if ($table != null) {
                $arrayFess = DB::table('fees as fe')
                    ->where("organisation_id","=",$this->organisation_id)
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
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }

    }
}
