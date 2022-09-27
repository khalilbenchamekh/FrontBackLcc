<?php


namespace App\Repository\FolderTech;

use App\Models\FolderTech;
use App\Repository\Log\LogTrait;
use DateTime;
use Illuminate\Support\Facades\Auth;

class FolderTechRepository implements IFolderTechRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }
    public function getFolderTech($request)
    {
        try{
            return FolderTech::latest()
            ->select('REF', 'id')
            ->paginate($request['limit'],['*'],'page',$request['page']);
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }


    public function save($request)
    {
        try{
        $now = new DateTime();
        $year = $now->format("Y");
        $nature_name = $request->input('nature_name');
        $nature_Abr_v_name = $request->input('nature_Abr_v_name');
        $place = $request->input('place');
        $count = FolderTech::where('nature_name', '=', $nature_name)->count();
        $count++;
        $ref = $nature_Abr_v_name . $count . "_" . $place . "_" . $year;
        $folderTech = new FolderTech();
        $folderTech->REF = $ref;
        $folderTech->PTE_KNOWN = $request->input('PTE_KNOWN');
        $folderTech->TIT_REQ = $request->input('TIT_REQ');
        $folderTech->place = $request->input('place');
        $folderTech->DATE_ENTRY = $request->input('DATE_ENTRY');
        $folderTech->DATE_LAI = $request->input('DATE_LAI');
        $folderTech->UNITE = $request->input('UNITE');
//        $folderTech->ARCHIVE=$request->input('ARCHIVE');
//        $folderTech->isValidate=$request->input('isValidate');
//        $folderTech->isPayed=$request->input('isPayed');
        $folderTech->organisation_id=$this->organisation_id;
        $folderTech->PRICE = $request->input('PRICE');
        $folderTech->Inter_id = $request->input('Inter_id');
        $folderTech->folder_sit_id = $request->input('aff_sit_id');
        $folderTech->Inter_id = $request->input('Inter_id');
        $folderTech->client_id = $request->input('client_id');
        $folderTech->resp_id = $request->input('resp_id');
        $folderTech->nature_name = $request->input('nature_name');
        $folderTech->save();

        return $folderTech;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function index($request)
    {
        try {
            return FolderTech::
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
            return FolderTech::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
    public function update(FolderTech $folderTech,$request)
    {
        try{
            $folderTech->update($request);
            return $folderTech;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function destroy($id)
    {
        try{
            return  FolderTech::where("id","=",$id)
                ->where("organisation_id",'=',$this->organisation_id)
                ->destroy();
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}

