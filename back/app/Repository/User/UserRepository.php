<?php

namespace App\Repository\User;
use App\Repository\Log\LogTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserRepository implements IUserRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function get($id)
    {
        try {
            //code...
            return User::where("id","=",$id)
            ->where("organisation_id",'=',$this->organisation_id)
            ->first();
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function update($preUser,$newUser)
    {
        try{
            $preUser->name=$newUser->name;
            $preUser->username=$newUser->username;
            $preUser->email =$newUser->email;
            $preUser->password=Hash::make($newUser->name);
            $preUser->firstname=$newUser->firstname;
            $preUser->middlename=$newUser->middlename;
            $preUser->lastname=$newUser->lastname;
            $preUser->gender=$newUser->gender;
            $preUser->birthdate=$newUser->birthdate;
            $preUser->address=$newUser->address;
            $preUser->directory=$newUser->directory;
            $preUser->filename=$newUser->filename;
            $preUser->original_filename=$newUser->original_filename;
            $preUser->filesize=$newUser->filesize;
            $preUser->url=$newUser->url;

            $preUser->save();

            return $preUser;

        }catch(\Exception $exception){
            $this->Log($exception);
            return null;
        }
    }

    public function getUser($request)
    {
        try {
            $users = User::latest()
            ->select('name', 'id', 'username')
            ->where("organisation_id","=",$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }


}
