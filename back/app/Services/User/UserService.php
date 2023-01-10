<?php

namespace App\Services\User;
use App\Repository\User\IUserRepository;
use Illuminate\Support\Facades\Auth;

class UserService implements IUserService
{
    private $iUserRepository;
    public function __construct(IUserRepository $iUserRepository)
    {
        $this->iUserRepository = $iUserRepository;
    }

    public function get($id)
    {
        // TODO: Implement get() method.
        return $this->iUserRepository->get($id);
    }

    public function update($newUser,$preUser=null)
    {
        if(is_null($preUser)){
            $preUser=Auth::user();
        }
        return $this->iUserRepository->update($preUser,$newUser);
    }
    public function getUser($request)
    {
        return $this->iUserRepository->getUser($request->all());
    }
    public function checkIfEmailOrNameExist($request)
    {
        return $this->iUserRepository->checkIfEmailOrNameExist($request);
    }
}
