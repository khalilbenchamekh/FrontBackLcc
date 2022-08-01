<?php

namespace App\Repository;

use App\Models\Message;
use App\Models\MessageFile;
use App\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ConversationRepository
{


    /**
     * @var User
     */
    private $user;
    /**
     * @var Message
     */
    private $message;


    /**
     * ConversationRepository constructor.
     * @param User $user
     * @param Message $message
     */
    public function __construct(User $user, Message $message)

    {

        $this->user = $user;
        $this->message = $message;
    }

    public function getconversations(int $userInt)
    {
        $conversations = $this->user->newQuery()->
        select('name', 'id', 'created_at')->where('id', '!=', $userInt)->get();
        return $conversations;
    }


    public function createmessage(User $from, User $to, Request $request)
    {
        $files = [];
        $type = '';
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
                'created_at' => Carbon::now()
            ]

        );
        if ($request->hasfile('filenames')) {
            $filesArray = [
                'geoMapping',
                'geoMapping/Messagerie',
            ];
            $pathToMove = 'geoMapping/Messagerie/';
            foreach ($filesArray as $item) {
                $path = storage_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }


            foreach ($request->file('filenames') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = md5($filename . time()) . '.' . $extension;
                array_push($files, [
                    "fileName" => $fileNameToStore
                ]);


                $path = public_path() . '/' . $pathToMove;
                $file->move($path, $fileNameToStore);
                $file = new MessageFile();
                $file->message()->associate(
                    $lastMessages->id
                );
                $file->fileName = $fileNameToStore;
                $file->save();
                $type = 'file';
            }

            if ($type == 'file') {
                $lastMessages->update(
                    [
                        'type' => $type
                    ]
                );
            }
        }

        return $lastMessages->setAttribute('files', $files);
    }

    public function getMessageFor(int $from, int $to): Builder
    {


        $mes = $this->message->newQuery()
            ->whereRaw("((from_id = $from AND to_id= $to ) OR (to_id = $from AND from_id =$to))")
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
        return $this->message->newQuery()->
        where('to_id', $user)
            ->groupBy('from_id')
            ->selectRaw('from_id, COUNT(id) as count')->whereRaw('read_at IS NULL')->get()->pluck('count', 'from_id');
    }

    /**
     * @param int $from
     * @param int $to
     */
    public function readfrommAll(int $from, int $to)
    {
        $this->message->where('from_id', $from)->where('to_id', $to)->update(['read_at' => Carbon::now()]);
    }
}
