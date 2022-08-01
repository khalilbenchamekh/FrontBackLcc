<?php

namespace App\Repository\AffaireSituation;

use App\Models\AffaireSituation;
use App\Repository\Log\LogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AffaireSituationRepository implements IAffaireSituationRepository
{
    use LogTrait;

    public function index($page)
    {
        // TODO: Implement index() method.
        $organisation_id=3;
        try {

            return DB::table("affairesituations")
                ->select()
                ->where("organisation_id","=",$organisation_id)
                ->paginate(15,['*'],"page",$page);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        try {
           return AffaireSituation::find($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function edit($perAffaireSituation, $data)
    {
        // TODO: Implement edit() method.
        try {
            $perAffaireSituation->Name=$data['Name'];
            $perAffaireSituation->orderChr=$data['orderChr'];
            $perAffaireSituation->save();
            return $perAffaireSituation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function delete($perAffaireSitution,$id)
    {
        // TODO: Implement delete() method.
        try {
            return $perAffaireSitution->delete();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function store($data)
    {
        $organisation_id=3;
        // TODO: Implement store() method.
        try {
            $affaireSituation = new AffaireSituation();
            $affaireSituation->organisation_id=$organisation_id;
            $affaireSituation->orderChr=$data['orderChr'];
            $affaireSituation->Name=$data['Name'];
            $affaireSituation->created_at=Carbon::now();
            $affaireSituation->save();
            return $affaireSituation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function storeMany($data)
    {
        $organisation_id=3;
        // TODO: Implement storeMany() method.
        $affaireSituations=[];
        try {
            foreach ($data as $item){
                $affaireSituation= new AffaireSituation();
                $affaireSituation->organisation_id=$organisation_id;
                $affaireSituation->Name=$item['Name'];
                $affaireSituation->orderChr=$item['orderChr'];
                $affaireSituation->save();
                array_push($affaireSituations,$affaireSituation);
            }
            return $affaireSituations;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
