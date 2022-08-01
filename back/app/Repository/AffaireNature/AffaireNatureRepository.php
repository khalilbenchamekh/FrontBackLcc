<?php

namespace App\Repository\AffaireNature;

use App\Models\AffaireNature;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Affaire;

class AffaireNatureRepository implements IAffaireNatureRepository
{
    use LogTrait;
    public function findAffaireNatureByName($name){
        try {
            return DB::table('affaire_natures')->where("Name","=",$name)->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function store($data)
    {

        try{
            $affireNature= new AffaireNature();
            $affireNature->Name=$data['Name'];
            $affireNature->Abr_v=$data['Abr_v'];
            $affireNature->organisation_id =$data['organisation_id'];
            $affireNature->save();
            return $affireNature;
        }catch (\Exception $exception){dd($exception->getMessage());
            $this->Log($exception);
            return null;
        }
    }
    public function getAllAffaireNature($id,$request)
    {
        try{
            return DB::table('affaire_natures')
                ->where('organisation_id','=',$id)
                ->paginate($request['limit'],['*'],'page',$request['page']);

        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id, $data)
    {
        // TODO: Implement get() method.
        try {
            return DB::table('affaire_natures')->where("id","=",$id)
                ->where("organisation_id",'=',$data['organisation_id'])
                ->get();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($affairNature, $data)
    {
        // TODO: Implement edit() method.
        try {
            $affairNature=new  AffaireNature();
            $affairNature->Name=$data['Name'];
            $affairNature->Abr_v=$data['Abr_v'];
            $affairNature->organisation_id=$data['organisation_id'];
            $affairNature->save();
            return $affairNature;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
     public function saveMany($data)
    {
        # code...

        try{

            $affaireCreated=[];
            for ($i=0; $i<count($data) ; $i++) {
                # code...
                $affairenature=new AffaireNature();
                $el=$data[$i];
                $affairenature->Name = $el['Name'];
                $affairenature->Abr_v = $el['Abr_v'];
                $affairenature->organisation_id=$el['organisation_id'];
                $affairenature->save();
                array_push($affaireCreated,$affairenature);
            }
            return $affaireCreated;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function destroy($id)
    {
        try{
            $affaire=new AffaireNature();
            $affaire::destroy($id);
            return $affaire;
        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
