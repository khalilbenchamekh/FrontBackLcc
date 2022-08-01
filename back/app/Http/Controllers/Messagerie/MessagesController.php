<?php
namespace App\Http\Controllers\Messagerie;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messagerie\StoreMessageRequest;
use App\Models\Message;
use App\Repository\ConversationRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class MessagesController extends Controller
{

    public function read(Request $request,Message $message){
       $message->update('read_at',Carbon::now());

        return response()->json(
            [
                'success'=>1
            ]
        );

    }


}
