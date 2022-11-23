<?php

namespace App\Repository\Resource;

use App\Http\Requests\Enums\TableChoice;
use App\Http\Resources\GetFess;
use App\Models\AllocatedBrigade;
use App\Models\Location;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResourceRepository implements IResourceRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
    }

    public function getLocationsAutoComplete($request,$order=null)
    {
        try {
            $locations = Location::select();
            if(!is_null($order)){
                $locations->latest();
            }
            $locations->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $locations;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function getAllocatedBrigades($request,$order=null)
    {
        try {
            $allocated_brigades =  AllocatedBrigade::select();
            if(!is_null($order)){
                $allocated_brigades->latest();
            }
            $allocated_brigades->where('organisation_id','=',$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $allocated_brigades;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function getFess(GetFess $fess)
    {
        $table = $fess->get_table();
        $arrayFess = DB::table($table . ' as af');
        switch ($fess->get_table()) {
            case TableChoice::Load:
                $arrayFess = $arrayFess
                    ->select(DB::raw('af.*'));
                break;
            case TableChoice::Business:
                $arrayFess = $arrayFess->where('organisation_id','=',$this->organisation_id)
                ->join('affairesituations as w', 'af.aff_sit_id', '=', 'w.id')
                    ->select(DB::raw('af.*'));
                break;
            case TableChoice::FolderTech:
                $arrayFess = $arrayFess->where('organisation_id','=',$this->organisation_id)->join('foldertechsituations as w', 'af.folder_sit_id', '=', 'w.id')
                    ->select(DB::raw('w.*'));
                break;
            case TableChoice::Great:
                $arrayFess = $arrayFess->where('organisation_id','=',$this->organisation_id)->join('locations as l', 'af.location_id', '=', 'l.id')
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
        $arrayFess = $arrayFess->where('organisation_id','=',$this->organisation_id)
            ->whereBetween('af.created_at', [$fess->get_from(), $fess->get_to()])
            ->get()
            ->reverse();
        return $arrayFess;
    }

    public function getDetails(GetFess $fess, $id)
    {
        $arrayFess = DB::table('fees as af')->join('business_managements as w', 'w.id', '=', 'af.business_id')
            ->where('organisation_id','=',$this->organisation_id)
            ->where('w.membership_id', '=', $id);

        switch ($fess->get_table()) {
            case TableChoice::Business:
                $arrayFess
                    ->where('organisation_id','=',$this->organisation_id)
                    ->where('w.membership_type', 'like', '%' . "Affaire");
                break;
            case TableChoice::FolderTech:
                $arrayFess
                    ->where('organisation_id','=',$this->organisation_id)
                    ->where('w.membership_type', 'like', '%' . "FolderTech");
                break;
            case TableChoice::Great:
                $arrayFess
                    ->where('organisation_id','=',$this->organisation_id)
                    ->where('w.membership_type', 'like', '%' . "GreatConstructionSites");
                break;

            default :
                return $arrayFess;
        }
        $arrayFess = $arrayFess
            ->select(
                DB::raw("af.*")
            )
            ->where('organisation_id','=',$this->organisation_id)
            ->get()
            ->reverse();
        return $arrayFess;
    }
}
