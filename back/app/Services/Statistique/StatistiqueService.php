<?php

namespace App\Service\Statistique;

use App\Http\Requests\Enums\ReportChoice;
use App\Http\Requests\Enums\StatistiquesChoices;
use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Repository\Statistique\IStatistiqueRepository;
use Carbon\Carbon;

class StatistiqueService implements IStatistiqueService
{
    public $iStatistiqueRepository;
    public function __construct(IStatistiqueRepository $iStatistiqueRepository)
    {
        $this->iStatistiqueRepository=$iStatistiqueRepository;
    }
    public function index($request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $orderBy = $request->input('orderBy');
        $table = TableChoice::All;
        $type = $request->input('type');
        $rapport = $request->input('rapport');
        $value = null;
        if (empty($from) || empty($to)) {
            $from = date("Y-m-d", strtotime(Carbon::now() . "-1 year"));
            $to = Carbon::now()->toDateString();
        }
        if (!empty($orderBy)) {
            $orderBy = 'year';
        }
        if (!empty($type)) {
            if ($type != StatistiquesChoices::Global) {
                if ($type == StatistiquesChoices::Employee) {
                    $value = $request->input('resp_id');
                } else {
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
            return $this->geetFessbusinessManagements($fess, $rapport, $value, $type);
        } else {
            $tempQuerie = $this->iStatistiqueRepository->MakeQueries($from, $to, $orderBy, $value, $type);
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
                            $this->iStatistiqueRepository->getFess($fess, $item)
                    ], $item))
                    : array_push($arrayToReturn, [
                    "$item" =>
                        $this->generateReport($fess, $value, $item, $report, $type)
                ]);
            }
        }
        return $arrayToReturn;
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

    private function FinancialReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->iStatistiqueRepository->getFessReport($fess, $value, $table, $type);
    }

    private function FinancialReportTva(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->iStatistiqueRepository->getFessReportTVA($fess, $value, $table, $type);
    }
    private function TurnoverReport(GetFess $fess, $value, String $table = null, $type = null)
    {
        return $this->iStatistiqueRepository->getFessReportCA($fess, $value, $table, $type);
    }
}
