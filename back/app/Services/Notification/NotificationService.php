<?php


namespace App\Service\Notification;

use App\Repository\Notification\INotificationRepository;

class NotificationService implements INotificationService
{
    public $iNotificationRepository;
    public function __construct(INotificationRepository $iNotificationRepository)
    {
        $this->iNotificationRepository=$iNotificationRepository;
    }

    public function insertNotification($data)
    {
        return $this->iNotificationRepository->insertNotification($data);
    }

    public function index($request,$order=null)
    {
        return $this->iNotificationRepository->index($request,$order);
    }

}
