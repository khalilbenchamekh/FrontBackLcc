<?php


namespace App\Repository\FolderTechSituation;

use App\Models\FolderTechSituation;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class FolderTechSituationRepository implements IFolderTechSituationRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function save($request)
    {
        try {
            //code...
            $foldertechsituation = new FolderTechSituation();
            $foldertechsituation->Name= $request['Name'];
            $foldertechsituation->orderChr=$request['orderChr'];
            $foldertechsituation->organisation_id=$this->organisation_id;

            $foldertechsituation->save();

            return $foldertechsituation;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try {
            return FolderTechSituation::
                select()
                ->where("organisation_id","=",$this->organisation_id)
                ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function show($id)
    {
        try {
            //code...
            return FolderTechSituation::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function update(FolderTechSituation $folderTechSituation,$request)
    {
        try {
            //code...
            $folderTechSituation->Name= $request['Name'];
            $folderTechSituation->orderChr=$request['orderChr'];
            $folderTechSituation->organisation_id=$this->organisation_id;

            $folderTechSituation->save();

            return $folderTechSituation;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($folderTechSituation)
    {
        try {
            //code...
            $deleted=$folderTechSituation;
            $deleted->delete();
            return $folderTechSituation;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

}
