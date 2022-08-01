<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ConversationWithRelationsResource.
 */
class ConversationWithRelationsResource extends JsonResource
{
    /**
     * @var \App\Models\Conversation
     */
    public $resource;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->resource->id,
            'name'         => $this->resource->name,
            'messages'     => MessageResource::collection($this->resource->messages),
            'participants' => ParticipantResource::collection($this->resource->participants),
            'created_at'   => $this->resource->created_at->toDateTimeString(),
            'updated_at'   => $this->resource->updated_at->toDateTimeString(),
        ];
    }
}
