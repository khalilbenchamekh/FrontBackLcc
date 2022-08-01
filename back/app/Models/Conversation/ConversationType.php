<?php

declare(strict_types=1);

namespace App\Models\Conversation;

use CommerceGuys\Enum\AbstractEnum;

/**
 * Class Type.
 */
class ConversationType extends AbstractEnum
{
    public const PRIVATE_DUAL = 'private_dual';
    public const PUBLIC_DISCUSSION = 'public_discussion';
}
