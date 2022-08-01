<?php

namespace App\Repository\Organisation;

use App\Organisation;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\DB;


class OrganisationRepository implements IOrganisationRepository
{
use LogTrait;
    public function getAll($req)
    {
        try {
            $org = DB::table('organisations')->select(['*'])
                ->where('deleted_at','=',null)
                ->where('deleted_by','=',null)
                ->paginate($req['limit'],['*'],'page',$req['page']);
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }
    public function getById($id):?Organisation
    {
        try {
            $org = Organisation::find($id);
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }

    }
    public function store($req,$cto):?Organisation
    {
        try {
            $org= new Organisation();
            $org->name=$req['name'];
            $org->emailOrganisation=$req['emailOrganisation'];
            $org->description=$req['description'];
            $org->owner=$req['owner'];
            $org->cto=$cto->id;
            $org->link1=$req['link1'];
            $org->link2=$req['link2'];
            $org->link3=$req['link3'];
            $org->link4=$req['link4'];
            $org->activer=$req['activer'];
            $org->desactiver=$req['desactiver'];
            $org->blocked=$req['blocked'];
            $org->save();
            return  $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
    public function edit($org,$req):?Organisation
    {
        try {

            $org->name=$req['name'];
            $org->emailOrganisation=$req['emailOrganisation'];
            $org->description=$req['description'];
            $org->owner=$req['owner'];
            $org->cto=$req['cto'];
            $org->link1=$req['link1'];
            $org->link2=$req['link2'];
            $org->link3=$req['link3'];
            $org->link4=$req['link4'];
            $org->activer=$req['activer'];
            $org->desactiver=$req['desactiver'];
            $org->blocked=$req['blocked'];
            $org->updated_at=time();
            $org->save();
            return  $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }
    public function delete($org)
    {
        try {
            $org->deleted_at=date('Y-m-d H:i:s');
            $org->save();
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }
    public function enable($org)
    {
        try {
            $org->activer=1;
            $org->desactiver=0;
            $org->save();
            return $org;
        }catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
    public function disable($org)
    {
        try {
            $org->desactiver=1;
            $org->activer=0;
            $org->save();
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }

    }
    public function block($org,$action)
    {
        try {
            $org->blocked=$action;
            $org->save();
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }

    }
    public function checkEmail($id,$email)
    {
        try {
            return DB::table('organisations')->where('emailOrganisation','=',$email)->where('id','!=',$id)->first();
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function saveImage($org,$fileName)
    {
        try {
            $org->file_avatar_name=$fileName;
            $org->save();
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }
    public function deleteImage($org)
    {
        try {
            $org->file_avatar_name=null;
            $org->save();
            return $org;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
    public function getOrganisationByCto($id)
    {
        try {
            $organisation=DB::table('organisations')->where("cto",'=',$id)
                ->where("deleted_at",'=',null)
                ->first();
                return $organisation;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getAllUserOrganisation(Organisation $organisation,$req)
    {
        try {
            return DB::table('users')->where('organisation_id','=',$organisation->id)
                ->where("deleted_at",'=',null)
                ->paginate($req['limit'],['*'],'page',$req['page']);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }
}
