<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class MessageCollection.
 */
class MessageCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = MessageResource::class;

    /**
     * Transform the resource collection into an array.
     *
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
