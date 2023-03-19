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
        $this->organisation_id = Auth::user() ? Auth::user()->organisation_id : null;
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
    public function index($request,$order=null)
    {
        try {
                $folderTechSituation= FolderTechSituation::where("organisation_id","=",$this->organisation_id)
                ->when($order != null, function($query){
                    return $query->orderBy('created_at', 'desc');
                })
                ->paginate($request['limit'],['*'],'page',$request['page']);
                return $folderTechSituation;
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
    public function destroy($id)
    {
        try {
            //code...
            $model= FolderTechSituation::where("organisation_id",'=',$this->organisation_id)->find($id);
            $deleted = $model;
            $deleted->delete();
            return $model;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

}
