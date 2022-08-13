<?php
namespace App\Repository\Conversation;
use App\User;
use Illuminate\Http\Request;
interface IConversationRepository
{
    public function getconversations(int $userInt);
    public function createmessage(User $from, User $to, Request $request);
    public function getMessageFor(int $from, int $to);
    public function unreadCount(int $user);
    public function readfrommAll(int $from, int $to);
}
