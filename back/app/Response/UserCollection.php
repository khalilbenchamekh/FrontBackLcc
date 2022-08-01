<?php
declare(strict_types=1);
namespace App\Response;

use App\User;
use Spatie\DataTransferObject\DataTransferObjectCollection;

final class UserCollection extends DataTransferObjectCollection
{
    public function current(): UserData
    {
        return parent::current();
    }

    /**
     * @param  User[]  $data
     * @return UserCollection
     */
    public static function fromArray(array $data): self
    {
        return new self(
            array_map(fn(User $item) => UserData::fromModel($item), $data)
        );
    }
}
