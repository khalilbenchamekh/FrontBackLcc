<?php

namespace App\Repository\Notification;


interface INotificationRepository
{
    public function insertNotification($data);
    public function index($request,$order=null);
}
