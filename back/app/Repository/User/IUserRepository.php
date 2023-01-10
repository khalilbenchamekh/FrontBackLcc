<?php

namespace App\Repository\User;

interface IUserRepository
{
public function get($id);
public function update($preUser,$newUser);
public function getUser($request);
public function checkIfEmailOrNameExist($request);
}
