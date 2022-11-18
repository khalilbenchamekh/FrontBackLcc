<?php
namespace App\Http\Controllers\Messagerie;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messagerie\StoreMessageRequest;
use App\Repository\Conversation\IConversationRepository;
use App\Services\SaveFile\ISaveFileService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConversationsController extends Controller
{
    private $con;
    private $iSaveFileService;
    public function __construct(ISaveFileService $iSaveFileService, IConversationRepository $con)
    {
        $this->con = $con;
        $this->iSaveFileService = $iSaveFileService;
    }

    public function index(){

        $user = JWTAuth::user();
    $conversations=$this->con->getconversations($user->id);
    $unread =$this->con->unreadCount($user->id);
    foreach ($conversations as $conversation){
        if (isset($unread[$conversation->id])){
            $conversation->unread=$unread[$conversation->id];
        }else{
            $conversation->unread=0;
        }
    }
        return response()->json(
            [
                'conversations'=>$conversations
            ]
        );

    }

    public function show(Request $request,User $user){

        $messagesQuery=$this->con->getMessageFor($request->user()->id,$user->id);
        $count =null;
        if($request->get('before')){
            $messagesQuery =$messagesQuery->where('created_at','<', $request->get('before'));
        }else{
            $count=$messagesQuery->count();
        }

        $messages= $messagesQuery->limit(10)->get();
        $update =false;
        foreach ($messages as $message){
            if($message->read_at === null && $message->to_id === $request->user()->id)
            {
                $message->read_at =Carbon::now();
                if($update===false){
                    $this->con->readfrommAll($message->from_id,$message->to_id) ;
                }
                $update =true;

            }
        }

        return response()->json(
        [
            'messages'=>array_reverse($messages->toArray()),
            'count'=>$count
        ]);
    }

    public function store(User $user,StoreMessageRequest $request)
    {
        $pathToMove = 'Messagerie/';
        $message= $this->con->createmessage(
            $request->user(),
            $user,
            $request
        );
        $message = $this->iSaveFileService->saveConversationFiles($message,$pathToMove,$request->file('filenames'));
        broadcast( new NewMessage($message));
        return response()->json(
            [
                'message'=>$message
            ]);
    }
}
