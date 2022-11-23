<?php

namespace App\Services\User;

interface IUserService
{
public function get($id);
public function update($newUser,$preUser=null);
public function getUser($request);
}
