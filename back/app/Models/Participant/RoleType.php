<?php

declare(strict_types=1);

namespace App\Models\Participant;

use CommerceGuys\Enum\AbstractEnum;

/**
 * Class Role.
 */
class RoleType extends AbstractEnum
{
    public const MEMBER = 'member';
    public const MODERATOR = 'moderator';
    public const ADMIN = 'admin';
    public const OWNER = 'owner';
}
