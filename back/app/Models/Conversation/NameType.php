<?php

declare(strict_types=1);

namespace App\Models\Conversation;

use CommerceGuys\Enum\AbstractEnum;

/**
 * Class NameType.
 */
class NameType extends AbstractEnum
{
    public const AUTO_GENERATED = 'auto_generated';
    public const MANUALLY_SPECIFIED = 'manually_specified';
}
