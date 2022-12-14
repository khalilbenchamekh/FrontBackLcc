<?php
namespace App\Repository\FeesFolderTech;
use App\Models\FeesFolderTech;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class FeesFolderTechRepository implements IFeesFolderTechRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function save($request)
    {
        try{
            $feesFolderTech= new FeesFolderTech();
            $feesFolderTech->organisation_id=$this->organisation_id;
            $feesFolderTech->advanced=$request['advanced'];
            $feesFolderTech->observation=$request['observation'];
            $feesFolderTech->folder_id=$request['id'];
            $feesFolderTech->save();
            return $feesFolderTech;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try{
            return FeesFolderTech::select()
            ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            dd($exception);
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try{
            return FeesFolderTech::where('id' ,'=', $id)->where('organisation_id','=',$this->organisation_id)->first();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function update(FeesFolderTech $feesFolderTech,$request)
    {
        try{
            $feesFolderTech->organisation_id=$this->organisation_id;
            $feesFolderTech->advanced=$request('advanced');
            $feesFolderTech->observation=$request('observation');
            $feesFolderTech->folder_id=$request('folder_id');
            $feesFolderTech->save();
            return $feesFolderTech;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try {
            //code...
            $feesFolderTech= $this->show($id);
            $deleted=$feesFolderTech;
            if($feesFolderTech instanceof FeesFolderTech){
                 $deleted->delete();
                 return $feesFolderTech;
            }
            return null;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
