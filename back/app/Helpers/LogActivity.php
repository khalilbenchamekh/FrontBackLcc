<?php


namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LogActivity as LogActivityModel;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogActivity
{
    private function AssocieteNameToSubject($subject, $user)
    {
        if ($user) {
            $name = $user->name;
            return $name . $subject;
        }
        return null;
    }

    public function addToLog($subject, Request $request)
    {
        $user = JWTAuth::user();
        $subject = $this->AssocieteNameToSubject($subject, $user);
        if ($subject != null) {
            $log = [];
            $log['subject'] = $subject;
            $log['url'] = $request->fullUrl();
            $log['method'] = $request->method();
            $log['ip'] = $request->ip();
            $log['agent'] = $request->header('user-agent');
            $log['user_id'] = $user->id;
            $log['user_name'] = $user->email;
            $notifications = new Notification();
            $notifications->description = $subject;
            $notifications->save();
            LogActivityModel::create($log);
        }

    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }


}
