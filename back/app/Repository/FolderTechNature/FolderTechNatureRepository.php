<?php


namespace App\Repository\FolderTechNature;


use App\Models\FolderTechNature;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class FolderTechNatureRepository implements IFolderTechNatureRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function getFolerTechNatureByName($id,$name)
    {
        try {
            return FolderTechNature::where("organisation_id","=",$this->organisation_id)
                ->where('id','!=',$id)
                ->where('Name','=',$name)
                ->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function save($request)
    {
        try {
            //code...
            $folderTechNature = new FolderTechNature();
            $name= $request['Name'];
            $abr_v= $request['Abr_v'];
            $abr_v=empty($abr_v) ? substr($name,0,3) : $abr_v;
            $folderTechNature->Name=$name;
            $folderTechNature->Abr_v=$abr_v;
            $folderTechNature->organisation_id=$this->organisation_id;
            $folderTechNature->save();
            return $folderTechNature;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function index($request,$order=null)
    {
        try {
                $folderTechNature= FolderTechNature::
                select();
                if(!is_null($order)){
                    $folderTechNature->latest();
                }
                $folderTechNature->where("organisation_id","=",$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);
                return $folderTechNature;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {

        try {
            //code...
            return FolderTechNature::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update(FolderTechNature $folderTechNature,$request)
    {
        try {
            //code...
            $name= $request['Name'];
            $abr_v= $request['Abr_v'];
            $abr_v=empty($abr_v) ? substr($name,0,3) : $abr_v;
            $folderTechNature->Name=$name;
            $folderTechNature->Abr_v=$abr_v;
            $folderTechNature->organisation_id=$this->organisation_id;

            $folderTechNature->save();
            return $folderTechNature;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try {
            return FolderTechNature::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();

        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
