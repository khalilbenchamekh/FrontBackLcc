<?php

namespace App\Repository\Admin;

use App\Repository\Log\LogTrait;
use App\Request\AdminRequest;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements IAdminRepository
{
use LogTrait;



    /**
     * @param $user
     * @param $id
     * @param $update_by
     * @return null
     */
    public function addIdToCto($user, $id)
    {
        try {
            $user->organisation_id =$id;
            $user->updated_at=date('Y-m-d H:i:s');
            $user->save();
            return $user;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    /**
     * @param $limit
     * @param $page
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllUser($limit, $page)
    {
        try {
            $users=DB::table('users')
                ->where('deleted_by','=',null)
                ->where("deleted_by",'=',null)
                ->paginate($limit,['*'],'page',$page);
            return $users;
        }catch(\Exception $exception){
            $this->Log($exception);
            return [];
        }
    }
    public function createUserToOrganisation($data,$organisation_id)
    {
        try {
            $newUser = new User();
            $newUser->name=$data['name'];
            $newUser->email=$data['email'];
            $newUser->password=Hash::make($data['password']);
            $newUser->organisation_id=$organisation_id;
            $newUser->save();
            return $newUser;
        }catch (\Exception $exception){
            dd($exception->getMessage());
            $this->Log($exception);
            return null;
        }
    }

    /**
     * @param $id
     * @return null
     */
    public function getByUser($id)
    {
        try {
            return  User::find($id);
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    /**
     * @param $data
     * @param $user
     * @param $editBy
     * @return User|null
     */
    public function editUser($user,$data)
    {
        try {
            $user->name=$data['name'];
            $user->email=$data['email'];
            $user->username=$data['username'];
            $user->last_signin=$data['last_signin'];
            $user->firstname=$data['firstname'];
            $user->middlename=$data['middlename'];
            $user->gender=$data['gender'];
            $user->birthdate=$data['birthdate'];
            $user->address=$data['address'];
            $user->directory=$data['directory'];
            $user->filename=$data['filename'];
            $user->original_filename=$data['original_filename'];
            $user->filesize=$data['filesize'];
            $user->thumbnail_filesize=$data['thumbnail_filesize'];
            $user->url=$data['url'];
            $user->membership_id=$data['membership_id'];
            $user->membership_type=$data['membership_type'];
            $user->thumbnail_url=$data['thumbnail_url'];
           // $user->organisation_id=$data['organisation_id'];
           array_key_exists('organisation_id', $data)?$user->organisation_id=$data['organisation_id']:null;
            $user->save();
            return $user;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    /**
     * @param $data
     * @param $user
     * @return User|null
     */
    public function createUser($data): ?User
    {
        try {
            $newUser = new User();
            $newUser->name=$data['name'];
            $newUser->email=$data['email'];
            $newUser->password=Hash::make($data['password']);
            ;
            $newUser->save();
            return $newUser;
        }catch (\Exception $exception){
            dd($exception);
            $this->Log($exception);
            return null;
        }
    }

    /**
     * @param $user
     * @param $deletedBy
     * @return null
     */
    public function deleteUser($user)
    {
        try {
        $user->deleted_at=time();
        $user->save();
        return $user;
        }catch (\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function enable($user)
    {
       $user->activer=1;
        $user->desactiver=0;
        $user->save();
       return $user;
    }

    public function disable($user)
    {
        $user->desactiver=1;
        $user->activer=0;
        $user->save();
        return $user;
    }

    public function generatePassword($user, $newPassword)
    {
        $user->password=$newPassword;
        $user->save();
        return $user;
    }

    public function getUserCount(): int
    {
        $count = User::all()->count();
        return $count;
    }

    public function block($user,$action)
    {
        $user->blocked=$action;
        $user->save();
        return $user;
    }

    public function checkEmail($id)
    {
        // TODO: Implement checkEmail() method.
    }
    public function getAllUserOrganisationToEmail($organisation_id,$cto_id)
    {
        try {
            $users=
                DB::table('users as u')
                ->where("u.organisation_id",'=',$organisation_id)
                ->where("u.deleted_at",'=',null)
                ->whereNotIn('u.id', DB::table('organisations as o')->select('o.cto')->where('o.cto', '=', $cto_id))
                ->get();
            return $users;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }

    public function saveImage($user, $fileName)
    {
        try {
            $user->fileName=$fileName;
            $user->save();
            return $user;
        }catch (\Exception $exception){
            $this->Log($exception);
            return  null;
        }
    }
}
