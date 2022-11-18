<?php

namespace App\Repository\User;
use App\Repository\Log\LogTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserRepository implements IUserRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation_id;
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
}
