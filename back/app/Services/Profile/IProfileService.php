<?php


namespace App\Service\Profile;


interface IProfileService
{
    public function me();
    public function update($request);
    public function updatePassword($request);
}
