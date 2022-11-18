<?php

namespace App\Repository\Conversation;

use App\Models\Message;
use App\Models\MessageFile;
use App\Repository\Conversation\IConversationRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ConversationRepository implements IConversationRepository
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Message
     */
    private $message;
    private $organisation_id;
    /**
     * ConversationRepository constructor.
     * @param User $user
     * @param Message $message
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
        $this->organisation_id = Auth::User()->organisation;
    }

    public function getconversations(int $userInt)
    {
        $conversations = $this->user->newQuery()->
        select('name', 'id', 'created_at')
        ->where('organisation_id','=',$this->organisation_id)
        ->where('id', '!=', $userInt)->get();
        return $conversations;
    }

    public function createmessage(User $from, User $to, Request $request)
    {
        $cont = $request->get('content');
        $lastMessages = $this->message->newQuery()->create(
            [
                'content' => $cont,
                'from' => [
                    'id' => $from->id,
                    'name' => $from->name,
                ],
                'from_id' => $from->id,
                'to_id' => $to->id,
                'organisation_id' => $this->organisation_id,
                'created_at' => Carbon::now()
            ]
        );
        return $lastMessages;
    }

    public function getMessageFor(int $from, int $to): Builder
    {
        $mes = $this->message->newQuery()
            ->whereRaw("((from_id = $from AND to_id= $to ) OR (to_id = $from AND from_id =$to))")
             ->where('organisation_id','=',$this->organisation_id)
            ->orderBy("created_at", "DESC")
            ->with(
                [
                    'from' => function ($query) {
                        return $query->select('name', 'id');
                    }, 'files'
                ]
            );

        return $mes;
    }

    /**
     * @param int $user
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function unreadCount(int $user)
    {
        return $this->message->newQuery()->where('organisation_id','=',$this->organisation_id)->where('to_id', $user)
            ->groupBy('from_id')
            ->selectRaw('from_id, COUNT(id) as count')->whereRaw('read_at IS NULL')->get()->pluck('count', 'from_id');
    }

    /**
     * @param int $from
     * @param int $to
     */
    public function readfrommAll(int $from, int $to)
    {
        $this->message->where('organisation_id','=',$this->organisation_id)->where('from_id', $from)->where('to_id', $to)->update(['read_at' => Carbon::now()]);
    }
}
