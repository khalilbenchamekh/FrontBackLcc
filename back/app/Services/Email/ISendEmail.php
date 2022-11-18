<?php

namespace App\Services\Email;

interface ISendEmail
{
    public function send($user ,string $action);
    public function email($to,$message);
    public function ResetPassword($to,$message);
}
