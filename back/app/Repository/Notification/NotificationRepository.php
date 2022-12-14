<?php

namespace App\Repository\Notification;

use App\Models\Notification;
use App\Repository\Log\LogTrait;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements INotificationRepository
{
    use LogTrait;
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = 3;
    }

    public function insertNotification($data)
    {
        try {
            $not = new Notification();
                $not->newQuery()->insert($data);
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }

    public function index($request,$order=null)
    {
        try {
            $not = Notification::select();
            if(!is_null($order)){
                $not->latest();
            }
            $not->where("organisation_id","=",$this->organisation_id)
            ->paginate($request['limit'],['*'],'page',$request['page']);
            return $not;
        } catch (\Exception $exception) {
            $this->Log($exception);
            return null;
        }
    }
}
