<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait UuidTrait.
 */
trait UuidTrait
{
    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return void
     */
    public static function bootUuidTrait(): void
    {
        static::creating(function (Model $model) {
            $model->incrementing = false;
            $model->setAttribute($model->getKeyName(), (string) Str::orderedUuid());
        });
    }
}
