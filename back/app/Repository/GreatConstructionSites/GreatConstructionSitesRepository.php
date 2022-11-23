<?php

namespace App\Repository\GreatConstructionSites;
use App\Models\AllocatedBrigade;
use App\Models\BusinessManagement;
use App\Models\GreatConstructionSites;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GreatConstructionSitesRepository implements IGreatConstructionSitesRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
    }

    public function dashboard($from,$to,$orderBy)
    {
         try {
            return DB::table('g_c_s as g')
            ->join('locations as l', 'g.location_id', '=', 'l.id')
            ->join('users as u', 'g.resp_id', '=', 'u.id')
            ->join('organisations as or', 'g.organisation_id', '=', 'or.id')
            ->where('g.organisation_id',"=",$this->organisation_id)
            ->whereBetween('g.date_of_receipt', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`g`.`date_of_receipt`) as `year`")
                    : DB::raw("MONTH(`g`.`date_of_receipt`) as `month`")
                ,
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='En cours') as `En_cours`"),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='Teminé') as `Teminé`"),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='En Attente de validation') as `En_Attente_de_validation`"),
                DB::raw("(SELECT count(`g`.`State_of_progress`) FROM `g_c_s` as `g` WHERE g.State_of_progress ='Annulé') as `Annulé`")
            )
            ->groupBy([$orderBy])
            ->get()
            ->reverse();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id){
        try {
            return GreatConstructionSites::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index()
    {
        try {
            return DB::table('g_c_s as g')
            ->join('locations as l', 'g.location_id', '=', 'l.id')
            ->join('users as u', 'g.resp_id', '=', 'u.id')
            ->join('organisations as or', 'g.organisation_id', '=', 'or.id')
            ->where('g.organisation_id',"=",$this->organisation_id)
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
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
     public function store($request)
    {
        try {
            $price = $request->input('price');
            $location_id = $request->input('location_id');
            $Market_title = $request->input('Market_title');
            $resp_id = $request->input('resp_id');
            $advanced = $request->input('advanced');
            $Execution_phase = $request->input('Execution_phase');
            $State_of_progress = $request->input('State_of_progress');
            $DATE_LAI = $request->input('DATE_LAI');
            $date_of_receipt = $request->input('date_of_receipt');
            $client_id = $request->input('client_id');
            $greatconstructionsites = new GreatConstructionSites();
            $greatconstructionsites->price = $price;
            $greatconstructionsites->organisation_id = $this->organisation_id;
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

        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function storeAllocatedBrigade($arrayToReturend){
        try {
            $toAssociete = [];
            foreach ($arrayToReturend as $field => $value) {
                $temp = AllocatedBrigade::updateOrCreate(["name" => $value,"organisation_id" => $this->organisation_id]);
                $id = [
                    'a_b_id' => $temp->id
                ];
                array_push($toAssociete,
                    $id
                );
            }
            return $toAssociete;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function storeBusinessManagement($ttc,$greatconstructionsites){
        try {
            $bus_mang = new BusinessManagement();
            $bus_mang->ttc = $ttc;
            $bus_mang->membership()->associate($greatconstructionsites);
            $bus_mang->save();
            return $bus_mang;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try {
            //code...

            return  GreatConstructionSites::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function getGreatConstructionSitesBetween($from, $to)
    {
        try {
            return GreatConstructionSites::whereBetween('DATE_LAI', [$from, $to])
            ->select('Market_title')
            ->get();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
