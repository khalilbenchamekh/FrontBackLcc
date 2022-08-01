<?php


namespace App\Repository\Load;

use App\Repository\Log\LogTrait;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Load;





class LoadRepository implements ILoadRepository
{
    use LogTrait;
    public function __construct()
    {


    }

        public function index($page)
        {
            $idUser=3;
            try{
                return DB::table('loads')
                    ->where('organisation_id','=',$idUser)
                    ->paginate(15,['*'],'page',$page);
            }catch(\Exception $exception){
                dd($exception->getMessage());
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
                $loads->save();
                return $loads;
            }catch(\Exception $exception){
                dd($exception);
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
                $load =Load::destroy($id);
                dd($load);
            }catch (\Exception $exception){
                $this->Log($exception);
                return null;
            }
        }

    public function show($id)
    {
        // TODO: Implement show() method.
        try {
            return Load::find($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
