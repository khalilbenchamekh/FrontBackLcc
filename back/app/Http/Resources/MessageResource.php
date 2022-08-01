<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MessageResource.
 */
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->resource->id,
            'participant' => ParticipantResource::make($this->resource->participant),
            'content'     => $this->resource->content,
            'created_at'  => $this->resource->created_at->toDateTimeString(),
            'updated_at'  => $this->resource->updated_at->toDateTimeString(),
        ];
    }
}
