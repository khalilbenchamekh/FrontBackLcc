<?php
namespace App\Repository\Load;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Load;
use Illuminate\Support\Facades\Auth;

class LoadRepository implements ILoadRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
    }
        public function index($request)
        {
            try{
                return DB::table('loads')
                    ->where('organisation_id','=',$this->organisation_id)
                    ->paginate($request['limit'],['*'],'page',$request['page']);
            }catch(\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }
        public function dashboard($from,$to,$orderBy)
        {
            try{
              return  DB::table('loads as g')
              ->where('g.organisation_id','=',$this->organisation_id)
            ->whereBetween('g.DATE_LOAD', [$from, $to])
            ->select(
                $orderBy === 'year' ?
                    DB::raw("YEAR(`g`.`DATE_LOAD`) as `year`")
                    : DB::raw("MONTH(`g`.`DATE_LOAD`) as `month`")
                ,
                DB::raw("(SELECT count(`g`.`DATE_LOAD`) FROM `loads` as `g`  ) as `charges`")
            )
            ->groupBy([$orderBy])
            ->get()
            ->reverse();
            }catch(\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }
        public function store($data)
        {
            try{
                $loads=new Load();
                $loads->organisation_id=$data["organisation_id"];
                $loads->REF=$data["REF"];
                $loads->DATE_LOAD= date("Y/m/d", strtotime($data['DATE_LOAD']));
                $loads->amount=$data["amount"];
                $loads->TVA =$data["TVA"];
                $loads->load_related_to =$data["load_related_to"];
                $loads->load_types_name =$data["load_types_name"];
                $loads->organisation_id=$this->organisation_id;
                $loads->save();
                return $loads;
            }catch(\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }
        public function edit($load,$data)
        {
            try {
                $load->organisation_id=$data["organisation_id"];
                $load->REF=$data["REF"];
                $load->DATE_LOAD= date("Y/m/d", strtotime($data['DATE_LOAD']));
                $load->amount=$data["amount"];
                $load->TVA =$data["TVA"];
                $load->load_related_to =$data["load_related_to"];
                $load->load_types_name =$data["load_types_name"];
                $load->organisation_id=$this->organisation_id;
                $load->save();
                return $load;
            }catch (\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }
        public function destroy($id)
        {
            try {
                return Load::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
            }catch (\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }

    public function show($id)
    {
        try {
            return Load::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
