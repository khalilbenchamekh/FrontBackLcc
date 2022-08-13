<?php


namespace App\Helpers;

use App\Http\Requests\Auth\PaginatinRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    private $organisation_id;
    public function __construct()
    {
        $this->organisation_id = Auth::User()->organisation;
    }
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
        $user = Auth::user();
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
            $log['organisation_id'] = $this->organisation_id;
            $notifications = new Notification();
            $notifications->description = $subject;
            $notifications->save();
            LogActivityModel::create($log);
        }

    }

    public function logActivityLists(PaginatinRequest $request)
    {
        return DB::table("log_activities")
        ->where('organisation_id','=', $this->organisation_id)
        ->paginate($request['limit'],['*'],'page',$request['page']);
    }
}
