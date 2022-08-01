<?php
declare(strict_types=1);

use App\Models\Conversation;
use App\Models\Conversation\ConversationType;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Participant\RoleType;
use App\User;
use Illuminate\Database\Seeder;
class MessagerieTableSeeder extends Seeder
{

    public function run()
    {


        /**
         * @var \Illuminate\Database\Eloquent\Collection
         * @var \Illuminate\Database\Eloquent\Collection $users
         */

     //   $users = factory(User::class, 8)->create();
//        $conversations = factory(Conversation::class, 250)->create([
//            'type' => ConversationType::PRIVATE_DUAL,
//        ]);
        for ($i = 0; $i < 5; $i++) {
            /**
             * @var \App\User
             * @var \App\Models\Conversation $conversation
             */
//            $conversation = $conversations->random();
//
//            do {
//                $user = $users->random();
//            } while ($conversation->participants()
//                ->where('user_id', $user->id)
//                ->first() !== null);
//
//            $participant = Participant::create([
//                'user_id'         => $user->id,
//                'conversation_id' => $conversation->id,
//                'role'            => $conversation->participants()
//                    ->where('role', RoleType::ADMIN)
//                    ->orWhere('role', RoleType::OWNER)
//                    ->count() > 0 ? RoleType::MEMBER : RoleType::ADMIN,
//            ]);
//
//            $conversation->participants()->save($participant);

            $user_from = rand(1,2);
            $user_to = rand(1,2);
            do {
                $user_from = rand(1,2);
                $user_to = rand(1,2);
            } while ($user_from ===$user_to);

            factory(Message::class, random_int(10, 50))->create([
                'from_id' => $user_from,
                'to_id'  => $user_to,
            ]);
        }
    }
}
