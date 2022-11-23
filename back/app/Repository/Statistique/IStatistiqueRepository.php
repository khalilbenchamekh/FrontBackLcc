<?php


namespace App\Repository\Statistique;

use App\Http\Resources\GetFess;

interface IStatistiqueRepository
{
    public function MakeQueries($from, $to, $orderBy, $value, $type = null);
    public function getFess(GetFess $fess, String $table = null);
    public function getFessReport(GetFess $fess, $value, String $table = null, $type = null);
    public function getFessReportTVA(GetFess $fess, $value, String $table = null, $type = null);
    public function getFessReportCA(GetFess $fess, $value, String $table = null, $type = null);
}
