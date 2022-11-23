<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 06/06/2020
 * Time: 14:14
 */

namespace App\Http\Controllers\Statistiques;


use App\Http\Controllers\Controller;
use App\Http\Requests\Statistiques\StatistiqueRequest;
use App\Service\Statistique\IStatistiqueService;

class StatistiquesController extends Controller
{
    public $iStatistiqueService;
    public function __construct(IStatistiqueService $iStatistiqueService)
    {
        $this->iStatistiqueService=$iStatistiqueService;
    }

    public function index(StatistiqueRequest $request)
    {
        $ongoingProject = $this->iStatistiqueService->index($request);
        return response()->json(["data" => $ongoingProject], 200);
    }

}
