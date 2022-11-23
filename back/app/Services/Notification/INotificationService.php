<?php


namespace App\Service\Notification;


interface INotificationService
{
    public function insertNotification($data);
    public function index($request,$order=null);
}
