<?php

namespace App\Services\User;
use App\Repository\User\IUserRepository;

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
}
