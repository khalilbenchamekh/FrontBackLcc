<?php

declare(strict_types=1);
namespace App\Response;

use App\User;
use Spatie\DataTransferObject\DataTransferObject;


class UserData extends DataTransferObject
{

    public int $id;
    public string $name;
    public string $email;

    public static function fromModel(User $user):self
    {
        return new self([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
