<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class ConversationCollection.
 */
class ConversationCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = ConversationResource::class;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'success' => true,
            'data'    => $this->collection,
        ];
    }
}
